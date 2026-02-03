<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendPaymentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:send-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim pengingat WhatsApp ke pengguna yang pembayarannya akan segera berakhir';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $waService)
    {
        $this->info('Memeriksa pembayaran yang akan berakhir...');

        // Cari transaksi yang:
        // 1. Statusnya 'pending' atau 'unpaid'
        // 2. Belum pernah dikirimi notifikasi WhatsApp (wa_notified_at is null)
        // 3. Waktu kadaluarsanya (expiry_time) tinggal <= 4 jam lagi
        // 4. Belum lewat waktu kadaluarsanya (masih di masa depan)

        $thresholdTime = now()->addHours(4);

        $pendingTransactions = Transaction::whereIn('status', ['pending', 'unpaid'])
            ->whereNull('wa_notified_at')
            ->whereNotNull('expiry_time')
            ->where('expiry_time', '<=', $thresholdTime)
            ->where('expiry_time', '>', now())
            ->with('user')
            ->get();

        $count = $pendingTransactions->count();
        $this->info("Ditemukan {$count} transaksi yang memerlukan pengingat.");

        foreach ($pendingTransactions as $transaction) {
            $user = $transaction->user;
            // Gunakan shipping_phone jika ada, jika tidak gunakan phone user
            $targetPhone = $transaction->shipping_phone ?: ($user ? $user->phone : null);

            if (!$targetPhone) {
                Log::warning("Gagal mengirim pengingat: Nomor telepon tidak ditemukan untuk transaksi #{$transaction->id}");
                continue;
            }

            // Sanitasi nomor telepon (pastikan format 62...)
            $targetPhone = $this->formatPhoneNumber($targetPhone);

            $expiryTime = Carbon::parse($transaction->expiry_time);
            $remainingHours = now()->diffInHours($expiryTime);
            $remainingMinutes = now()->diffInMinutes($expiryTime) % 60;

            $timeLabel = "";
            if ($remainingHours > 0) {
                $timeLabel .= "{$remainingHours} jam ";
            }
            if ($remainingMinutes > 0) {
                $timeLabel .= "{$remainingMinutes} menit";
            }

            $message = "Halo {$transaction->shipping_name},\n\n";
            $message .= "Kami dari U-Market ingin menginformasikan bahwa pesanan Anda dengan ID *#{$transaction->order_id}* akan segera berakhir waktu pembayarannya dalam *{$timeLabel}* lagi.\n\n";
            $message .= "Total Pembayaran: *Rp " . number_format($transaction->total_price, 0, ',', '.') . "*\n\n";
            $message .= "Segera lakukan pembayaran agar pesanan Anda tidak dibatalkan secara otomatis oleh sistem.\n\n";
            $message .= "Terima kasih telah berbelanja di U-Market!";

            $this->info("Mengirim pesan ke {$targetPhone}...");
            $response = $waService->sendMessage($targetPhone, $message);

            if ($response['status']) {
                $transaction->wa_notified_at = now();
                $transaction->save();
                $this->info("Berhasil mengirim pengingat untuk transaksi #{$transaction->id}");
            } else {
                $this->error("Gagal mengirim pengingat ke {$targetPhone}: " . ($response['message'] ?? 'Unknown error'));
            }
        }

        $this->info('Selesai.');
    }

    /**
     * Format phone number to 62...
     */
    protected function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 2) === '62') {
            // Already correct
        } else {
            // Assume it's without country code and append 62
            $phone = '62' . $phone;
        }

        return $phone;
    }
}

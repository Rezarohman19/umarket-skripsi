<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Mail\PaymentReminderMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
    protected $description = 'Kirim pengingat Email ke pengguna yang pembayarannya akan segera berakhir';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memeriksa pembayaran yang akan berakhir...');

        $thresholdTime = now()->addHour(1);

        $pendingTransactions = Transaction::whereIn('status', ['pending', 'unpaid'])
            ->whereNull('wa_notified_at') // Keeping the field name to track notification state
            ->whereNotNull('expiry_time')
            ->where('expiry_time', '<=', $thresholdTime)
            ->where('expiry_time', '>', now())
            ->with('user')
            ->get();

        $count = $pendingTransactions->count();
        $this->info("Ditemukan {$count} transaksi yang memerlukan pengingat.");

        foreach ($pendingTransactions as $transaction) {
            $user = $transaction->user;
            $targetEmail = $user ? $user->email : null;

            if (!$targetEmail) {
                Log::warning("Gagal mengirim pengingat: Email tidak ditemukan untuk transaksi #{$transaction->id}");
                continue;
            }

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

            $this->info("Mengirim email ke {$targetEmail}...");
            
            try {
                Mail::to($targetEmail)->send(new PaymentReminderMail($transaction, $timeLabel));
                
                $transaction->wa_notified_at = now(); // Mark as notified
                $transaction->save();
                
                $this->info("Berhasil mengirim pengingat untuk transaksi #{$transaction->id}");
            } catch (\Exception $e) {
                $this->error("Gagal mengirim email ke {$targetEmail}: " . $e->getMessage());
                Log::error("Failed to send payment reminder email: " . $e->getMessage());
            }
        }

        $this->info('Selesai.');
    }
}

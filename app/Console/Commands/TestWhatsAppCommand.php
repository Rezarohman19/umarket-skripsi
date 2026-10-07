<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Http;

class TestWhatsAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wa:test {phone? : Nomor tujuan WhatsApp (contoh: 08123456789)} {--status : Cek status koneksi device Fonnte saja}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tes koneksi WhatsApp API Fonnte dan kirim pesan uji coba';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = config('services.fonnte.token') ?: env('FONNTE_TOKEN');

        if (empty($token)) {
            $this->error('FONNTE_TOKEN belum diatur di file .env atau config/services.php');
            return Command::FAILURE;
        }

        $this->info('Memeriksa status perangkat Fonnte...');

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/device');

            $deviceInfo = $response->json();

            if ($response->successful() && ($deviceInfo['status'] ?? false)) {
                $this->info('Status Perangkat WhatsApp:');
                $this->table(
                    ['Parameter', 'Nilai'],
                    [
                        ['Nama Perangkat', $deviceInfo['name'] ?? '-'],
                        ['Nomor Terhubung', $deviceInfo['device'] ?? '-'],
                        ['Status Koneksi', $deviceInfo['device_status'] ?? '-'],
                        ['Paket', $deviceInfo['package'] ?? '-'],
                        ['Sisa Kuota Pesan', $deviceInfo['quota'] ?? '-'],
                        ['Masa Aktif', $deviceInfo['expired'] ?? '-'],
                    ]
                );
            } else {
                $this->warn('Gagal mendapatkan status perangkat: ' . ($deviceInfo['reason'] ?? 'Unknown error'));
            }
        } catch (\Exception $e) {
            $this->error('Error saat menghubungi server Fonnte: ' . $e->getMessage());
            return Command::FAILURE;
        }

        if ($this->option('status')) {
            return Command::SUCCESS;
        }

        $phone = $this->argument('phone');

        if (!$phone) {
            $phone = $this->ask('Masukkan nomor WhatsApp tujuan uji coba (contoh: 08123456789):');
        }

        if (empty($phone)) {
            $this->warn('Nomor tidak boleh kosong.');
            return Command::FAILURE;
        }

        $formattedPhone = WhatsAppService::formatPhoneNumber($phone);
        $this->info("Mengirim pesan uji coba ke {$formattedPhone}...");

        $wa = new WhatsAppService();
        $testMessage = "🛍️ *U-Market - Universitas Lampung*\n\n"
            . "Halo! Ini adalah pesan uji coba dari sistem notifikasi otomatis E-Commerce U-Market.\n\n"
            . "✅ Integrasi WhatsApp API (Fonnte) berhasil aktif!\n"
            . "🕒 Waktu: " . now()->format('d/m/Y H:i:s') . " WIB\n\n"
            . "_Pesan ini dikirim otomatis oleh sistem skripsi U-Market._";

        $result = $wa->sendMessage($formattedPhone, $testMessage);

        if ($result['status']) {
            $this->info("✅ Pesan berhasil terkirim ke {$formattedPhone}!");
            return Command::SUCCESS;
        } else {
            $this->error("❌ Gagal mengirim pesan: " . ($result['message'] ?? 'Unknown error'));
            return Command::FAILURE;
        }
    }
}

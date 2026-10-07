<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $token;
    protected $baseUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = config('services.fonnte.token') ?: env('FONNTE_TOKEN');
    }

    /**
     * Format nomor telepon ke format internasional Indonesia (628xxx).
     * Mendukung format: 08xxx, +628xxx, 628xxx, 8xxx
     *
     * @param string $phone
     * @return string
     */
    public static function formatPhoneNumber($phone)
    {
        // Hapus karakter non-digit kecuali +
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        // Hapus + di awal jika ada
        $phone = ltrim($phone, '+');

        // Konversi format 08xxx ke 628xxx
        if (str_starts_with($phone, '08')) {
            $phone = '62' . substr($phone, 1);
        }
        // Konversi format 8xxx ke 628xxx
        elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Cek apakah service WhatsApp aktif (token tersedia).
     *
     * @return bool
     */
    public function isEnabled()
    {
        return !empty($this->token);
    }

    /**
     * Send a WhatsApp message.
     *
     * @param string $target WhatsApp number (e.g., 628123456789 atau 08123456789)
     * @param string $message Message content
     * @return array
     */
    public function sendMessage($target, $message)
    {
        if (!$this->isEnabled()) {
            Log::warning('WhatsApp Service: FONNTE_TOKEN is not set. Skipping notification.');
            return ['status' => false, 'message' => 'Token not set'];
        }

        // Format nomor telepon otomatis
        $target = self::formatPhoneNumber($target);

        if (strlen($target) < 10) {
            Log::warning("WhatsApp Service: Invalid phone number: $target");
            return ['status' => false, 'message' => 'Invalid phone number'];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->baseUrl, [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Indonesia
            ]);

            $result = $response->json();

            if ($response->successful()) {
                Log::info("WhatsApp message sent to $target", ['response' => $result]);
                return ['status' => true, 'data' => $result];
            } else {
                Log::error("WhatsApp message failed to $target", ['response' => $result]);
                return ['status' => false, 'message' => $result['reason'] ?? 'Unknown error'];
            }
        } catch (\Exception $e) {
            Log::error("WhatsApp Service Exception: " . $e->getMessage());
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Kirim notifikasi pesanan baru ke seller.
     */
    public function notifySellerNewOrder($sellerPhone, $buyerName, $orderId, $totalPrice)
    {
        $message = "🛒 *Pesanan Baru di U-Market!*\n\n"
            . "Pembeli: *{$buyerName}*\n"
            . "Order ID: {$orderId}\n"
            . "Total: Rp " . number_format($totalPrice, 0, ',', '.') . "\n\n"
            . "Status: Menunggu Pembayaran\n"
            . "Silakan cek dashboard toko Anda.";

        return $this->sendMessage($sellerPhone, $message);
    }

    /**
     * Kirim notifikasi pembayaran berhasil ke seller.
     */
    public function notifySellerPaymentReceived($sellerPhone, $buyerName, $orderId, $totalPrice)
    {
        $message = "✅ *Pembayaran Diterima!*\n\n"
            . "Pembeli: *{$buyerName}*\n"
            . "Order ID: {$orderId}\n"
            . "Total: Rp " . number_format($totalPrice, 0, ',', '.') . "\n\n"
            . "Segera proses dan kirimkan pesanan ini.";

        return $this->sendMessage($sellerPhone, $message);
    }

    /**
     * Kirim notifikasi pesanan dikirim ke buyer.
     */
    public function notifyBuyerOrderShipped($buyerPhone, $orderId, $sellerName)
    {
        $message = "📦 *Pesanan Anda Sedang Dikirim!*\n\n"
            . "Order ID: {$orderId}\n"
            . "Penjual: *{$sellerName}*\n\n"
            . "Pesanan Anda sedang dalam perjalanan. "
            . "Anda dapat melacak pesanan di aplikasi U-Market.";

        return $this->sendMessage($buyerPhone, $message);
    }

    /**
     * Kirim notifikasi pesanan sampai ke buyer.
     */
    public function notifyBuyerOrderDelivered($buyerPhone, $orderId)
    {
        $message = "🎉 *Pesanan Anda Telah Sampai!*\n\n"
            . "Order ID: {$orderId}\n\n"
            . "Jika pesanan sudah diterima dengan baik, "
            . "silakan konfirmasi penerimaan di aplikasi U-Market.\n\n"
            . "Terima kasih telah berbelanja! 🛍️";

        return $this->sendMessage($buyerPhone, $message);
    }

    /**
     * Kirim notifikasi pengajuan pengembalian ke seller.
     */
    public function notifySellerReturnRequested($sellerPhone, $buyerName, $orderId)
    {
        $message = "⚠️ *Pengajuan Pengembalian*\n\n"
            . "Pembeli: *{$buyerName}*\n"
            . "Order ID: {$orderId}\n\n"
            . "Pembeli mengajukan pengembalian untuk pesanan ini. "
            . "Silakan tinjau di dashboard toko Anda.";

        return $this->sendMessage($sellerPhone, $message);
    }

    /**
     * Kirim notifikasi pengembalian disetujui ke buyer.
     */
    public function notifyBuyerReturnApproved($buyerPhone, $orderId)
    {
        $message = "✅ *Pengembalian Disetujui*\n\n"
            . "Order ID: {$orderId}\n\n"
            . "Pengajuan pengembalian Anda telah disetujui oleh penjual. "
            . "Silakan ikuti instruksi pengembalian di aplikasi U-Market.";

        return $this->sendMessage($buyerPhone, $message);
    }
}

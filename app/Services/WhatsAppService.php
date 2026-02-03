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
     * Send a WhatsApp message.
     *
     * @param string $target WhatsApp number (e.g., 628123456789)
     * @param string $message Message content
     * @return array
     */
    public function sendMessage($target, $message)
    {
        if (!$this->token) {
            Log::error('WhatsApp Service: FONNTE_TOKEN is not set.');
            return ['status' => false, 'message' => 'Token not set'];
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
}

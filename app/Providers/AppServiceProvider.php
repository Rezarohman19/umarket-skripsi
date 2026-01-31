<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Midtrans\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Customizing the email verification message
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verifikasi Alamat Email Anda - U-Market')
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.')
                ->action('Verifikasi Email', $url)
                ->line('Jika Anda tidak merasa membuat akun, abaikan email ini.')
                ->salutation('Salam hangat, Tim U-Market');
        });

        // Initialize Midtrans config from config/midtrans.php
        try {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production', false) ? true : false;
            Config::$isSanitized = config('midtrans.is_sanitized', true);
            Config::$is3ds = config('midtrans.is_3ds', true);
        } catch (\Throwable $e) {
            // Fail silently if Midtrans package unavailable at boot
        }
    }
}

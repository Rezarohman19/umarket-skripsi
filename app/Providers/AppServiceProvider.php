<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Midtrans\Config;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Transport\Smtp\Stream\SocketStream;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Get the appropriate base URL for email links (accessible from both phone and PC).
     */
    public static function getPublicBaseUrl(): string
    {
        // 1. If APP_URL is configured as a public HTTPS URL (like Vercel)
        $appUrl = config('app.url');
        if (!empty($appUrl) && str_starts_with($appUrl, 'https://')) {
            return rtrim($appUrl, '/');
        }

        // 2. If the current request came through an external domain
        if (request()->hasHeader('Host')) {
            $host = request()->getHost();
            if (!in_array($host, ['localhost', '127.0.0.1', '0.0.0.0', '::1'])) {
                $scheme = request()->isSecure() || str_ends_with($host, '.vercel.app') || str_ends_with($host, '.trycloudflare.com') ? 'https' : request()->getScheme();
                return $scheme . '://' . $host;
            }
        }

        return config('app.url', 'https://umarket-skripsi.vercel.app');
    }

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
        // Robust SMTP Transport Driver with DNS fallback and peer_name TLS support
        Mail::extend('smtp', function (array $config) {
            $originalHost = $config['host'] ?? 'smtp.gmail.com';
            $targetHost = $originalHost;

            if (!filter_var($originalHost, FILTER_VALIDATE_IP)) {
                $resolved = @gethostbyname($originalHost);
                if ($resolved && $resolved !== $originalHost) {
                    $targetHost = $resolved;
                } else {
                    $fallbacks = ['142.251.10.108', '142.251.12.108', '172.217.194.108', '74.125.130.108'];
                    foreach ($fallbacks as $fb) {
                        $fp = @stream_socket_client("tcp://$fb:587", $e1, $e2, 1.5);
                        if ($fp) {
                            fclose($fp);
                            $targetHost = $fb;
                            break;
                        }
                    }
                }
            }

            $port = (int) ($config['port'] ?? 587);
            $stream = new SocketStream();
            $stream->setHost($targetHost);
            $stream->setPort($port);
            $stream->setStreamOptions([
                'ssl' => [
                    'peer_name' => $originalHost,
                    'verify_peer' => true,
                    'verify_peer_name' => true,
                ]
            ]);
            if (isset($config['timeout'])) {
                $stream->setTimeout($config['timeout']);
            }

            $transport = new EsmtpTransport($targetHost, $port, false, null, null, $stream);
            if (!empty($config['username'])) {
                $transport->setUsername($config['username']);
            }
            if (!empty($config['password'])) {
                $transport->setPassword($config['password']);
            }

            return $transport;
        });

        // Custom URL for Email Verification (generates signed relative URL attached to public base)
        VerifyEmail::createUrlUsing(function ($notifiable) {
            $base = self::getPublicBaseUrl();
            $relativeUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ],
                false // relative
            );

            return rtrim($base, '/') . $relativeUrl;
        });

        // Customizing the email verification message
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $fromAddress = config('mail.from.address') ?: 'marketunila@gmail.com';
            return (new MailMessage)
                ->from($fromAddress, 'U-Market Unila')
                ->replyTo($fromAddress, 'U-Market Unila')
                ->subject('[U-Market] Verifikasi Alamat Email Anda')
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Terima kasih telah mendaftar di U-Market (E-Commerce Universitas Lampung).')
                ->line('Silakan klik tombol di bawah ini untuk memverifikasi dan mengaktifkan akun Anda:')
                ->action('Verifikasi Email Saya', $url)
                ->line('Tautan verifikasi ini berlaku selama 60 menit.')
                ->line('Jika tombol di atas tidak dapat diklik pada aplikasi email Anda, silakan salin tautan berikut dan buka di peramban browser Anda:')
                ->line($url)
                ->line('Jika Anda tidak merasa mendaftar di U-Market, silakan abaikan email ini.')
                ->salutation('Salam hangat, Tim Pengembang U-Market');
        });

        // Custom URL for Reset Password (generates route attached to public base)
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            $base = self::getPublicBaseUrl();
            $path = route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false); // relative

            return rtrim($base, '/') . $path;
        });

        // Customizing the reset password message
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = call_user_func(ResetPassword::$createUrlCallback, $notifiable, $token);
            return (new MailMessage)
                ->subject('Permintaan Reset Kata Sandi - U-Market')
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Anda menerima email ini karena kami menerima permintaan pengaturan ulang kata sandi untuk akun U-Market Anda.')
                ->action('Atur Ulang Sandi', $url)
                ->line('Tautan pengaturan ulang sandi ini akan kedaluwarsa dalam 60 menit.')
                ->line('Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini.')
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

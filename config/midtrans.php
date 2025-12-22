<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,
    // Comma-separated list in .env, e.g. MIDTRANS_ENABLED_PAYMENTS=credit_card,gopay,bank_transfer
    'enabled_payments' => env('MIDTRANS_ENABLED_PAYMENTS') ? array_map('trim', explode(',', env('MIDTRANS_ENABLED_PAYMENTS'))) : null,
];

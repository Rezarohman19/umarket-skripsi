# Setup Admin Account

## Cara Membuat Admin Account

Gunakan salah satu metode berikut:

### Metode 1: Menggunakan Tinker (Recommended)

```bash
php artisan tinker
```

Kemudian di console tinker:

```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123'),
    'role' => 'admin'
]);
```

### Metode 2: Menggunakan Migration/Seeder

Edit file `database/seeders/DatabaseSeeder.php` dan tambahkan:

```php
use App\Models\User;

public function run(): void
{
    // Admin user
    User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password123'),
        'role' => 'admin'
    ]);

    // Regular user
    User::create([
        'name' => 'User Regular',
        'email' => 'user@example.com',
        'password' => bcrypt('password123'),
        'role' => 'pengguna'
    ]);
}
```

Kemudian jalankan:

```bash
php artisan db:seed
```

## Login Credentials

### Admin

-   Email: `admin@example.com`
-   Password: `password123`
-   Dashboard: `/admin/dashboard`

### Regular User

-   Email: `user@example.com`
-   Password: `password123`
-   Dashboard: `/` (landing page) dan `/dashboard` (user dashboard)

## How It Works

1. User login dengan email dan password di `/login` (sama untuk admin dan user)
2. System akan check role di database
3. Jika role = 'admin' → redirect ke `/admin/dashboard`
4. Jika role = 'pengguna' → redirect ke `/` (landing page)

Middleware `admin` melindungi semua routes dengan prefix `/admin/` dan hanya mengizinkan user dengan role = 'admin'

# Frontend Vue.js - E-Commerce U-Market

## Struktur Folder

```
resources/js/
├── app.js              # Entry point untuk welcome page
├── app-login.js         # Entry point untuk login page
├── App.vue              # Root component untuk welcome page
├── bootstrap.js         # Konfigurasi axios dan CSRF token
├── components/          # Komponen Vue yang reusable
│   └── ExampleComponent.vue
├── views/               # Halaman/Views Vue
│   └── Login.vue        # Halaman Login
└── composables/         # Reusable logic (composables)
    └── useAuth.js       # Composable untuk authentication
```

## Endpoint API yang Dibutuhkan

Frontend membutuhkan endpoint berikut dari backend:

### POST /login
Request body:
```json
{
    "email": "user@example.com",
    "password": "password123",
    "remember": true
}
```

Response success:
```json
{
    "message": "Login berhasil",
    "user": { ... }
}
```

Response error:
```json
{
    "message": "Email atau kata sandi salah",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password field is required."]
    }
}
```

### POST /logout
Logout user dan clear session.

### GET /api/user
Get current authenticated user.

## Catatan

- Semua file frontend berada di `resources/js/` dan `resources/views/`
- Tidak ada perubahan pada file backend (routes, controllers, models)
- CSRF token otomatis di-set dari meta tag di blade template
- Menggunakan axios untuk API calls


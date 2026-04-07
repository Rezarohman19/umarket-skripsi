import axios from "axios";

window.axios = axios;

// Configuration untuk Sanctum Session-based Auth
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.headers.common["Accept"] = "application/json";
window.axios.defaults.withCredentials = true;
window.axios.defaults.withXSRFToken = true;

// Ambil CSRF token dari meta tag Blade
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
if (csrfToken) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
}

// Interceptor untuk menangani error 401 (Unauthorized)
window.axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            // Cek apakah user memang harus redirect (halaman private)
            const privatePages = ['/cart', '/checkout', '/orders', '/profile', '/open-shop'];
            const isPrivatePage = privatePages.includes(window.location.pathname) || window.location.pathname.startsWith('/admin/');

            if (isPrivatePage) {
                // Hanya hapus jika memang di halaman private (berarti sesi habis)
                localStorage.removeItem("user");
                window.location.href = "/login?expired=true";
            }
        }
        return Promise.reject(error);
    },
);

// Catatan: Jika Anda ingin kembali menggunakan Token-based auth, 
// aktifkan kembali authService.restoreToken() di sini.
// Namun untuk website ini kita fokus pada Sesi (Sanctum).

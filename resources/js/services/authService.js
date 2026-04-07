import axios from "axios";

const API_BASE = "/api";

/**
 * Auth Service - Handle API authentication dengan token-based Sanctum
 */
const authService = {
    /**
     * Login dengan email & password
     * @param {string} email
     * @param {string} password
     * @returns {Promise<{token, user}>}
     */
    async login(email, password) {
        try {
            const response = await axios.post(`${API_BASE}/auth/login`, {
                email,
                password,
            });

            const { token, user } = response.data;

            // Simpan token di localStorage
            localStorage.setItem("auth_token", token);
            localStorage.setItem("user", JSON.stringify(user));

            // Update axios header
            axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

            return { token, user };
        } catch (error) {
            throw error.response?.data || { message: "Login failed" };
        }
    },

    /**
     * Register user baru
     * @param {string} name
     * @param {string} email
     * @param {string} password
     * @param {string} passwordConfirmation
     * @returns {Promise<{token, user}>}
     */
    async register(name, email, password, passwordConfirmation) {
        try {
            const response = await axios.post(`${API_BASE}/auth/register`, {
                name,
                email,
                password,
                password_confirmation: passwordConfirmation,
            });

            const { token, user } = response.data;

            // Simpan token di localStorage
            localStorage.setItem("auth_token", token);
            localStorage.setItem("user", JSON.stringify(user));

            // Update axios header
            axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

            return { token, user };
        } catch (error) {
            throw error.response?.data || { message: "Registration failed" };
        }
    },

    /**
     * Logout - revoke token
     * @returns {Promise}
     */
    async logout() {
        try {
            await axios.post(`${API_BASE}/auth/logout`);
        } catch (error) {
            console.error("Logout error:", error);
        } finally {
            // Clear token dari localStorage regardless
            localStorage.removeItem("auth_token");
            localStorage.removeItem("user");
            delete axios.defaults.headers.common["Authorization"];
        }
    },

    /**
     * Get current token
     * @returns {string|null}
     */
    getToken() {
        return localStorage.getItem("auth_token");
    },

    /**
     * Get current user dari localStorage
     * @returns {object|null}
     */
    getUser() {
        const user = localStorage.getItem("user");
        return user ? JSON.parse(user) : null;
    },

    /**
     * Check apakah user sudah login
     * @returns {boolean}
     */
    isAuthenticated() {
        return !!this.getToken();
    },

    /**
     * Restore token ke axios header (dipanggil saat app initialize)
     */
    restoreToken() {
        const token = this.getToken();
        if (token) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        }
    },

    /**
     * Set authorization header manually
     * @param {string} token
     */
    setAuthHeader(token) {
        if (token) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        } else {
            delete axios.defaults.headers.common["Authorization"];
        }
    },
};

export default authService;

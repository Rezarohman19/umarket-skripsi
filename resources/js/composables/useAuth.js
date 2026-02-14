import axios from 'axios';

export function useAuth() {
    const login = async (email, password, remember = false) => {
        try {
            const response = await axios.post('/login', {
                email,
                password,
                remember
            });

            return {
                success: true,
                data: response.data,
                message: 'Login berhasil'
            };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Email atau kata sandi salah',
                errors: error.response?.data?.errors
            };
        }
    };

    const logout = async () => {
        try {
            await axios.post('/logout');
            window.location.href = '/login';
            return { success: true };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Gagal logout'
            };
        }
    };

    const getUser = async () => {
        try {
            const response = await axios.get('/api/user');
            return {
                success: true,
                data: response.data
            };
        } catch (error) {
            return {
                success: false,
                data: null
            };
        }
    };

    return {
        login,
        logout,
        getUser
    };
}


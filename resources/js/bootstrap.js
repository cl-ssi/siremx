import _ from 'lodash';
import axios from 'axios';
import $ from 'jquery';

window._ = _;
window.$ = $;
window.jQuery = $;

// Crear instancia configurada ANTES de exportar
const axiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL || '/',
    withCredentials: true, // CRÍTICO: enviar cookies de sesión
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});

// CSRF token se configura dinámicamente en cada request
axiosInstance.interceptors.request.use(config => {
    const token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        config.headers['X-CSRF-TOKEN'] = token.content;
    }
    return config;
});

// Interceptor para manejar errores de sesión
axiosInstance.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401 || error.response?.status === 419) {
            // Sesión expirada o inválida
            window.location.href = '/auth/login';
        }
        return Promise.reject(error);
    }
);


window.axios = axiosInstance;

export default axiosInstance;
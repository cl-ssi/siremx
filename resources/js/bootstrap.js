import _ from 'lodash';
import axios from 'axios';
import $ from 'jquery';

window._ = _;
window.$ = $;
window.jQuery = $;

const axiosInstance = axios.create({
    baseURL: '/',
    withCredentials: true,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});

axiosInstance.interceptors.request.use(config => {
    // SIEMPRE intentar ambas fuentes, no solo una u otra

    // 1. Meta tag CSRF-TOKEN
    const metaToken = document.head.querySelector('meta[name="csrf-token"]');
    if (metaToken) {
        config.headers['X-CSRF-TOKEN'] = metaToken.content;
        console.log('✓ Meta CSRF-TOKEN:', metaToken.content.substring(0, 20) + '...');
    } else {
        console.log('✗ Meta CSRF-TOKEN no encontrado');
    }

    // 2. Cookie XSRF-TOKEN (CRÍTICO para Laravel)
    const xsrfMatch = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
    if (xsrfMatch) {
        config.headers['X-XSRF-TOKEN'] = decodeURIComponent(xsrfMatch[1]);
        console.log('✓ Cookie X-XSRF-TOKEN:', decodeURIComponent(xsrfMatch[1]).substring(0, 20) + '...');
    } else {
        console.log('✗ Cookie XSRF-TOKEN no encontrada');
    }

    console.log('Headers finales:', {
        'X-CSRF-TOKEN': config.headers['X-CSRF-TOKEN'] ? 'presente' : 'ausente',
        'X-XSRF-TOKEN': config.headers['X-XSRF-TOKEN'] ? 'presente' : 'ausente'
    });

    return config;
});

axiosInstance.interceptors.response.use(
    response => response,
    error => {
        console.error('Error Axios:', error.response?.status, error.response?.data);
        if (error.response?.status === 401 || error.response?.status === 419) {
            window.location.href = '/auth/login';
        }
        return Promise.reject(error);
    }
);

window.axios = axiosInstance;

export default axiosInstance;
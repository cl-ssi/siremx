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
    const token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        config.headers['X-CSRF-TOKEN'] = token.content;
    }
    return config;
});

axiosInstance.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401 || error.response?.status === 419) {
            window.location.href = '/auth/login';
        }
        return Promise.reject(error);
    }
);

window.axios = axiosInstance;

export default axiosInstance;
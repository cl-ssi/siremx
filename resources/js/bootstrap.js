import _ from 'lodash';
import axios from 'axios';
import $ from 'jquery';

window._ = _;
window.$ = $;
window.jQuery = $;

// Axios config
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.withCredentials = true;

// CSRF token (Laravel)
const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// ✅ IMPORTANTE: usar Vite env
axios.defaults.baseURL = import.meta.env.VITE_API_URL;

// Global
window.axios = axios;
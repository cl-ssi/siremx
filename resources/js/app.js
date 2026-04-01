import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import router from './routes';
import axiosInstance from './bootstrap'; // Importar la instancia configurada
import moment from 'moment';
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';
import es from 'element-plus/es/locale/lang/es';
import mitt from 'mitt';
import Swal from 'sweetalert2';

const EventBus = mitt(); // Event Bus
const app = createApp(App); // Crear app

// Global properties
app.config.globalProperties.$axios = axiosInstance;
app.config.globalProperties.$moment = moment;
app.config.globalProperties.$bus = EventBus;
app.config.globalProperties.$swal = Swal;

// Plugins
app.use(ElementPlus, { locale: es });
app.use(router);

// Mount
app.mount('#app');

// (Opcional) acceso global
window.EventBus = EventBus;
window.Swal = Swal;
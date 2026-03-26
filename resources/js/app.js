import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';
import moment from 'moment';
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';
import es from 'element-plus/es/locale/lang/es';
import mitt from 'mitt';
import Swal from 'sweetalert2';
import router from './routes';
import Auth from './components/Auth.vue';

export const EventBus = mitt();
window.EventBus = EventBus;
window.Swal = Swal;
window.axios = axios;

const app = createApp(Auth);

app.config.globalProperties.$moment = moment;
app.use(ElementPlus, { locale: es });
app.use(router);
app.component('Auth', Auth);
app.mount('#app');

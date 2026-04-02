import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import router from './routes';
import axiosInstance from './bootstrap';
import moment from 'moment';
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';
import es from 'element-plus/es/locale/lang/es';
import mitt from 'mitt';
import Swal from 'sweetalert2';

const EventBus = mitt();
const app = createApp(App);

app.config.globalProperties.$axios = axiosInstance;
app.config.globalProperties.$moment = moment;
app.config.globalProperties.$bus = EventBus;
app.config.globalProperties.$swal = Swal;

app.use(ElementPlus, { locale: es });
app.use(router);

app.mount('#app');

window.EventBus = EventBus;
window.Swal = Swal;
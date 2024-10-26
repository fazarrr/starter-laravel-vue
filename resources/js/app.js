import '@/Assets/css/satoshi.css';
import '@/Assets/css/style.css';
import 'jsvectormap/dist/jsvectormap.min.css';
import 'flatpickr/dist/flatpickr.min.css';

// import './bootstrap';
import { createApp } from "vue";
import { createPinia } from 'pinia';
import VueApexCharts from 'vue3-apexcharts';

import App from '@/App.vue';
import router from '@/Routers/index';

const app  = createApp(App);

app.use(createPinia());
app.use(router);
app.use(VueApexCharts);

app.mount("#app");
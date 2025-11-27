import { createApp } from 'vue';
import App from './App.vue';
import router from '@/router';

import Vue3Toastify, { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

import VueAxios from "vue-axios";
import axios from "@/plugin/axios.js";

import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({
  components,
  directives,
});

const app = createApp(App);

app.use(
  Vue3Toastify,
  {
    autoClose: 3000,
    position: toast.POSITION.BOTTOM_RIGHT,
  }
);

app.use(VueAxios, axios);
app.provide('axios', app.config.globalProperties.axios);

app.use(vuetify);
app.use(router);
app.mount('#app');

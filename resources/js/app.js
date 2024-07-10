import './bootstrap';
import router from "./router/router";
import { createApp } from "vue";
import axios from "axios";

import App from "./App.vue";
axios.defaults.baseURL = 'https://square-payment.test/api/';
axios.defaults.headers.common['Content-Type'] = 'application/json';
createApp(App).use(router).mount("#app");
import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import App from "./components/App.vue";
import router from "./router";
import{ createPinia } from "pinia";

const pinia = createPinia();
const app = createApp({
    components: {
        App,
    }
});

app.use(router);
app.use(pinia);
app.mount('#app');

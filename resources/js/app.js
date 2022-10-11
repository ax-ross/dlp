import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import App from "./components/App.vue";
import router from "./router";

const app = createApp({
    components: {
        App,
    }
});

app.use(router);
app.mount('#app');

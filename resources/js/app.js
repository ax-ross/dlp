import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import App from "./components/App.vue";
import router from "./router";
import{ createPinia } from "pinia";
import CKEditor from "@ckeditor/ckeditor5-vue";

const pinia = createPinia();
const app = createApp({
    components: {
        App
    }
});

app.use(CKEditor);
app.use(router);
app.use(pinia);
app.mount('#app');

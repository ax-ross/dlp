import './bootstrap';

import '../css/styles.scss'

import * as bootstrap from 'bootstrap'

import {createApp} from 'vue/dist/vue.esm-bundler';
import RegisterForm from "./components/Auth/RegisterForm.vue";

const RegisterApp = createApp({
    components: {
        RegisterForm
    }
}).mount('#register-form');

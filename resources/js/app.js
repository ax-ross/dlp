import './bootstrap';

import '../css/styles.scss'

import * as bootstrap from 'bootstrap'

import {createApp} from 'vue/dist/vue.esm-bundler';
import RegisterForm from "./components/Auth/RegisterForm.vue";
import CreateInvitation from "./components/Teacher/CreateInvitation.vue";
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { Ziggy } from './ziggy';

const RegisterFormApp = createApp({
    components: {
        RegisterForm
    }
}).use(ZiggyVue, Ziggy).mount('#register-form');
const CreateInvitationApp = createApp({
   components: {
       CreateInvitation
   }
}).mount('#create-invitation');

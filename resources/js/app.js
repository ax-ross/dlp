import './bootstrap';

import '../css/styles.scss'

import * as bootstrap from 'bootstrap'

import {createApp} from 'vue/dist/vue.esm-bundler';
import RegisterForm from "./components/Auth/RegisterForm.vue";
import CreateInvitation from "./components/Teacher/CreateInvitation.vue";

const RegisterFormApp = createApp({
    components: {
        RegisterForm
    }
}).mount('#register-form');
const CreateInvitationApp = createApp({
   components: {
       CreateInvitation
   }
}).mount('#create-invitation');

<template>
    <auth-layout>
        <div class="md:m-10 sm:m-5 m-2.5">
            <p class="text-xl mb-8 text-center font-bold">Сброс пароля</p>
            <div v-if="successMessage" class="bg-green-300 font-bold text-white">
                {{ successMessage }}
            </div>
            <div class="flex flex-col mb-3">
                <label for="email" class="mb-2 pl-3">Email</label>
                <input v-model="email" type="email" class="border rounded-lg p-1.5 pl-3" id="email">
                <div v-if="validationErrors.email" class="mt-1.5">
                    <div v-for="error in validationErrors.email">
                        <div class="text-red-600 text-sm">
                            {{ error }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mb-10">
                <button @click.prevent="resetPassword" class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl">Восстановить пароль</button>
            </div>
            <div class="flex flex-col text-sm text-center">
                <span class="mb-2">Нету аккаунта?</span>
                <router-link :to="{ name: 'register' }" class="text-blue-400">Зарегестрироваться</router-link>
            </div>
        </div>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../layouts/AuthLayout.vue";
import axios from "axios";

export default {
    name: "ResetPassword",
    components: {AuthLayout},
    data() {
        return {
            email: '',
            validationErrors: {},
            successMessage: ''
        }
    },
    methods: {
        resetPassword() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/forgot-password', {email: this.email}).then( () => {
                    this.successMessage = 'Письмо для сменя пароля успешно направлено на Вашу почту'
                }).catch(({response}) => {
                    if (response.status === 422) {
                        this.validationErrors = response.data.errors;
                    }
                })
            });
        }
    }

}
</script>

<style scoped>

</style>

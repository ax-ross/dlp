<template>
    <auth-layout>
        <div class="md:m-10 sm:m-5 m-2.5">
                <p class="text-xl mb-8 text-center font-bold">Вход</p>
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
                <div class="flex flex-col mb-10">
                    <label for="password" class="mb-2 pl-3">Пароль</label>
                    <input v-model="password" type="password" class="border rounded-lg p-1.5 pl-3" id="password">
                    <router-link :to="{ name: 'reset-password' }" class="text-blue-400">Забыли пароль?</router-link>
                </div>
                <div v-if="validationErrors.login" class="mt-1.5 mb-4 text-center">
                    <div class="text-red-600 text-sm">
                        {{ validationErrors.login }}
                    </div>
                </div>
                <div class="text-center mb-10">
                    <button @click.prevent="login" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-2xl">Войти</button>
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
import router from "../../router";
import { useAuthStore } from "../../stores/auth";
import { mapStores } from 'pinia';

export default {
    name: "Login",
    components: {
        AuthLayout
    },
    computed: {
      ...mapStores(useAuthStore),
    },
    data() {
        return {
            email: '',
            password: '',
            validationErrors: {}
        }
    },
    methods: {
        login() {
           axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', {email: this.email, password: this.password}).then(async ({data}) => {
                    await this.authStore.addAuthUserToStore();
                    if (this.authStore.authenticated) {
                        await router.push({name: 'index'});
                    } else {
                        await router.push({name: 'welcome'});
                    }
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

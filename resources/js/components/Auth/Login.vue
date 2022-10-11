<template>
    <auth-layout>
        <div class="shadow-2xl md:p-10 sm:p-5 p-2.5">
            <router-link :to="{ name: 'index' }" class="text-blue-400 text-sm">На главную</router-link>
            <div class="md:m-10 sm:m-5 m-2.5">
                <p class="text-xl mb-8 text-center font-bold">Вход</p>
                <div class="flex flex-col mb-3">
                    <label for="email" class="mb-2 pl-3">Email</label>
                    <input v-model="email" type="email" class="border rounded-lg p-1.5 pl-3" id="email">
                </div>
                <div class="flex flex-col mb-10">
                    <label for="password" class="mb-2 pl-3">Пароль</label>
                    <input v-model="password" type="password" class="border rounded-lg p-1.5 pl-3" id="password">
                </div>
                <div class="text-center mb-10">
                    <button @click.prevent="login" class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl">Войти</button>
                </div>
                <div class="flex flex-col text-sm text-center">
                    <span class="mb-2">Нету аккаунта?</span>
                    <router-link :to="{ name: 'register' }" class="text-blue-400">Зарегестрироваться</router-link>
                </div>
            </div>

        </div>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../layouts/AuthLayout.vue";
import router from "../../router";

export default {
    name: "Login",
    components: {
        AuthLayout
    },
    data() {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie');
            axios.post('/login', {email: this.email, password: this.password}).then(({data}) => {
                router.push( {name: 'teacher'} )
            })
        }
    }
}
</script>

<style scoped>

</style>

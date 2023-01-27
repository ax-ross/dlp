<template>
    <div class="container mx-auto flex items-center flex-col min-h-screen justify-center">
        <p class="font-bold text-3xl">Добро пожаловать на Платформу дистанционного обучения</p>

        <div class="flex mt-10">
            <router-link :to="{ name: 'login' }" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-4 px-8 rounded-2xl mr-10 text-xl">
                Вход
            </router-link>
            <router-link :to="{ name: 'register' }" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-4 px-8 rounded-2xl text-xl">
                Регистрация
            </router-link>
        </div>

    </div>
</template>

<script>
import { mapState } from 'pinia';
import { useAuthStore } from "../stores/auth";
import router from '../router';

export default {
    name: "Index",
}
</script>

<style scoped>

</style>

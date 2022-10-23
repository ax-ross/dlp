<template>
    <auth-layout>
        <div class="md:m-10 sm:m-5 m-2.5">
                    <p class="text-xl mb-10 text-center font-bold">Регистрация</p>
                <div class="flex flex-col mb-3">
                    <label for="name" class="mb-2 pl-3">Имя</label>
                    <input v-model="name" type="text" class="border rounded-lg p-1.5 pl-3" id="name">
                    <div v-if="validationErrors.name" class="mt-1.5">
                        <div v-for="error in validationErrors.name">
                            <div class="text-red-600 text-sm">
                                {{ error }}
                            </div>
                        </div>
                    </div>
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
                <div class="flex flex-col mb-3">
                    <label for="password" class="mb-2 pl-3">Пароль</label>
                    <input v-model="password" type="password" class="border rounded-lg p-1.5 pl-3" id="password">
                    <div v-if="validationErrors.password" class="mt-1.5">
                        <div v-for="error in validationErrors.password">
                            <div class="text-red-600 text-sm">
                                {{ error }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col mb-4">
                    <label for="password_confirmation" class="mb-2 pl-3">Подтвердите пароль</label>
                    <input v-model="password_confirmation" type="password" class="border rounded-lg p-1.5 pl-3" id="password_confirmation">
                </div>
                <div class="flex">
                    <input v-model=role type="radio" id="role-teacher" value="teacher">
                    <label for="role-teacher" class="pl-1.5">Я учитель</label>
                </div>
                <div class="flex mb-4">
                    <input v-model=role type="radio" id="role-student" value="student">
                    <label for="role-student" class="pl-1.5">Я ученик</label>
                </div>
                <div class="text-center mb-10">
                    <button @click.prevent="register" class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl">Зарегестрироваться</button>
                </div>
                <div class="flex flex-col text-sm text-center">
                    <span class="mb-2">Уже зарегестрированы?</span>
                    <router-link :to="{ name: 'login' }" class="text-blue-400">Войти</router-link>
                </div>
            </div>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../layouts/AuthLayout.vue";
import router from "../../router";
import {useAuthStore} from "../../stores/auth";

export default {
    name: "Register",
    components: {
        AuthLayout
    },
    setup() {
        const authStore = useAuthStore();

        return  { authStore }
    },
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            role: '',
            validationErrors: {}
        }
    },
    methods: {
        register() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/register', {name: this.name, email: this.email, password: this.password, password_confirmation: this.password_confirmation, role: this.role}).then(async ({data}) => {
                    await this.authStore.addAuthUserToStore();
                    if (this.authStore.authenticated) {
                        if (this.authStore.user.role === 'teacher') {
                            await router.push({name: 'teacher'});
                        } else {
                            await router.push({name: 'student'});
                        }
                    } else {
                        await router.push({name: 'index'});
                    }
                }).catch(({response}) => {
                    if (response.status === 422) {
                        this.validationErrors = response.data.errors;
                        console.log(this.validationErrors.email[0]);
                    }
                })
            });

        }
    },

}
</script>

<style scoped>

</style>

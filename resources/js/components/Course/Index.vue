<template>
    <p class="text-2xl">Мои курсы</p>
    <div v-if="authStore.user.role === 'teacher'" class="my-5">
        <router-link class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl" :to="{ name: 'courses.create' }">Создать курс</router-link>
    </div>
    <div class="container flex flex-wrap">
        <router-link v-for="course in courses" :to="{name: 'courses.show', params: {'id': course.id}}" class="hover:shadow-xl p-5 m-2 min-w-[25%] border rounded-2xl cursor-pointer">
            <div>{{ course.title }}</div>
            <div class="mt-5 text-sm flex justify-between">
                <div>
                    Учитель: {{ course.teacher.name }}
                </div>

                <div>
                    Учеников: {{ course.students.length }}
                </div>
            </div>

        </router-link>
    </div>

</template>

<script>

import {mapStores} from "pinia";
import {useAuthStore} from "../../stores/auth";

export default {
    name: "Index",
    data() {
        return {
            courses: null
        }
    },
    computed: {
        ...mapStores(useAuthStore)
    },
    mounted() {
        this.getCourses();
    },
    methods: {
        getCourses() {
            axios.get('/api/courses').then((data) => {
                this.courses = data.data.data;
            });
        }
    }
}
</script>

<style scoped>

</style>

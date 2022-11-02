<template>
    <p class="text-2xl">Мои курсы</p>
    <div class="my-5">
        <router-link class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl" :to="{ name: 'teacher.courses.create' }">Создать курс</router-link>
    </div>
    <div class="container flex flex-wrap">
        <div v-for="course in courses" class="hover:shadow-xl p-5 m-2 min-w-[25%] border rounded-2xl cursor-pointer">
            <div>{{ course.title }}</div>
            <div class="mt-5 text-sm flex justify-between">
                <div>
                    Учитель: {{ course.teacher.name }}
                </div>

                <div>
                    Учеников: {{ course.students.length }}
                </div>
            </div>

        </div>
    </div>

</template>

<script>

export default {
    name: "Index",
    data() {
        return {
            courses: null
        }
    },
    mounted() {
      this.getCourses();
    },
    methods: {
        getCourses() {
            axios.get('/api/courses').then((data) => {
                this.courses = data.data.data;
                console.log(this.courses);
            });
        }
    }
}
</script>

<style scoped>

</style>

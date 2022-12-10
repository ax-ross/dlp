<template>
    <p class="text-2xl">Мои курсы</p>
    <div class="container flex flex-wrap">
        <router-link v-for="course in courses" :to="{name: 'student.courses.show', params: {'id': course.id}}" class="hover:shadow-xl p-5 m-2 min-w-[25%] border rounded-2xl cursor-pointer">
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
            });
        }
    }
}
</script>

<style scoped>

</style>

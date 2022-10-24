<template>
    <h2>КУРСЫ</h2>
    <div v-for="course in courses">
        <div>
            <p class="text-4xl font-bold">{{ course.title }}</p>
            <p class="text-4xl font-bold">{{ course.teacher_id }}</p>
            <br>
            <div v-for="student in course.students">
                {{ student.name }}
                <br>
                {{ student.email }}
                <br>
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

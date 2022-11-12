<template>
    <div>
        Название курса: {{ course.title }}
    </div>
    <div v-if="course.teacher">
        Учитель: {{ course.teacher.name }}
    </div>
    <div>
        Ученики:
        <div v-for="student in course.students">
            <div>
                {{ student.name }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Show",
    data () {
        return {
            course: {},
        }
    },
    created() {
        this.id = this.$route.params['id'];
        axios.get(`/api/courses/${this.$route.params['id']}`).then( (data) => {
            this.course = data.data.data
            console.log(this.course);
        })
    }
}
</script>

<style scoped>

</style>

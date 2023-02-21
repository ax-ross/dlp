<template>
    <div v-if="lesson">
        <div>
            {{ lesson.title }}
        </div>
        <div v-html="lesson.content">

        </div>
    </div>

</template>

<script>
export default {
    name: "Show",
    data(){
        return {
            lesson: {}
        }
    },
    mounted() {
        this.getLesson()
    },
    methods: {
        getLesson() {
            axios.get(`/api/courses/${this.$route.params.course_id}/lessons/${this.$route.params.lesson_id}`).then((data) => {
                this.lesson = data.data.data;
            })
        }
    }
}
</script>

<style scoped>

</style>

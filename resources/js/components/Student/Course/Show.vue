<template>
    <div>
        Название курса: {{ course.title }}
    </div>
    <div v-if="course.teacher">
        Учитель: {{ course.teacher.name }}
    </div>
    <div v-if="course.chat">
        Чат: <router-link :to="{name: 'student.courses.chat', params: {'id': course.id}}" >{{ course.chat.title }}</router-link>
    </div>
    <div>
        Ученики:
        <div v-for="student in course.students">
            <div class="flex">
                {{ student.name }}
            </div>
        </div>
    </div>
</template>

<script>
import {PencilSquareIcon} from "@heroicons/vue/24/outline"


export default {
    name: "Show",
    components: {
      PencilSquareIcon
    },
    data () {
        return {
            course: {},
        }
    },
    created() {
        this.id = this.$route.params['id'];
        axios.get(`/api/courses/${this.$route.params['id']}`).then( (data) => {
            this.course = data.data.data
        })
    },
}
</script>

<style scoped>

</style>

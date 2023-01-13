<template>
    <div class="mb-3">
        <div class="text-center text-2xl">{{ course.title }}</div>
    </div>
        <div v-if="course.chat" class="mb-5">
            <router-link class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl" :to="{name: 'student.courses.chat', params: {'id': course.id}}" >Открыть чат курса</router-link>
        </div>
    <div v-if="course.teacher" class=" flex">
        <div class="p-3">Учитель:</div>
        <div class="border rounded-2xl cursor-pointer hover:shadow-xl p-3"> {{ course.teacher.name }}</div>
    </div>
    <div class="p-3">
        <div class="mb-3">
            Ученики:
        </div>
        <div v-for="student in course.students">
            <div>
                <div class="flex">
                    <div class="border rounded-2xl cursor-pointer hover:shadow-xl p-5 flex">
                        {{ student.name }}
                    </div>

                </div>
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

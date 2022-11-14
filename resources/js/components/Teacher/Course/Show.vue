<template>
    <div v-if="titleEdit" class="flex">
        <div class="mr-2">
            <input v-model="newTitle" type="text" class="border rounded-lg p-1 pl-3" id="title" :placeholder="course.title">
            <div v-if="validationErrors.title" class="mt-1.5">
                <div v-for="error in validationErrors.title">
                    <div class="text-red-600 text-sm">
                        {{ error }}
                    </div>
                </div>
            </div>
        </div>
        <div class="mr-2">
            <button @click="updateTitle">сохранить</button>
        </div>
        <div class="my-auto">
            <button @click="editTitle"><pencil-square-icon class="w-5 h-5"></pencil-square-icon></button>
        </div>

    </div>
    <div v-else>
        Название курса: {{ course.title }} <button @click="editTitle"><pencil-square-icon class="w-3"></pencil-square-icon></button>
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
import {PencilSquareIcon} from "@heroicons/vue/24/outline"


export default {
    name: "Show",
    components: {
      PencilSquareIcon
    },
    data () {
        return {
            course: {},
            titleEdit: false,
            newTitle: '',
            validationErrors: {}
        }
    },
    created() {
        this.id = this.$route.params['id'];
        axios.get(`/api/courses/${this.$route.params['id']}`).then( (data) => {
            this.course = data.data.data
        })
    },
    methods: {
        editTitle() {
            this.titleEdit = !this.titleEdit
        },
        updateTitle() {
            axios.post(`/api/courses/${this.course.id}`, {title: this.newTitle}).then(() => {
                axios.get(`/api/courses/${this.course.id}`).then((data) => {
                    this.course = data.data.data
                    this.titleEdit = false;
                })
            }).catch(({response}) => {
                if (response.status === 422) {
                    this.validationErrors = response.data.errors;
                }
            })
        }
    }
}
</script>

<style scoped>

</style>

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
        <div v-if="studentAdd" class="flex">
            <div class="mr-2">
                <div>
                    <label class="flex" for="studentEmail">Введите email студента:</label>
                    <input v-model="studentEmail" type="text" class="border rounded-lg p-1 pl-3" id="studentEmail" :placeholder="studentEmail">
                    <div class="mr-2">
                        <button @click="addStudent">добавить</button>
                    </div>
                    <div class="">
                        <button @click="addingStudent">отмена</button>
                    </div>
                </div>

                <div v-if="validationErrors.email" class="mt-1.5">
                    <div v-for="error in validationErrors.email">
                        <div class="text-red-600 text-sm">
                            {{ error }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div v-else>
            <button class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl" @click.prevent="addingStudent">Добавить студента</button>

        </div>
        <div v-for="student in course.students">
            <div>
                {{ student.name }}
            </div>
        </div>
    </div>
</template>

<script>
import {PencilSquareIcon} from "@heroicons/vue/24/outline"
import student from "../../../middleware/student";


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
            validationErrors: {},
            studentAdd: false,
            studentEmail: '',
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
        },
        addingStudent() {
            this.studentAdd = !this.studentAdd;
        },
        addStudent() {
            axios.post(`/api/courses/${this.course.id}/add-student`, {email: this.studentEmail}).then(() => {
                axios.get(`/api/courses/${this.course.id}`).then((data) => {
                    this.course = data.data.data
                    this.studentAdd = false;
                }).catch(({response}) => {
                    if (response.status === 422) {
                        this.validationErrors = response.data.errors;
                    }
                })
            });
        }
    }
}
</script>

<style scoped>

</style>

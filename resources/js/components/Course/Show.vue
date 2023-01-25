<template>

    <div v-if="titleEdit" class="flex mb-3 justify-center">
        <div class="mr-2">
            <input v-model="newTitle" type="text" class="border rounded-lg p-1 pl-3" id="title">
            <div v-if="validationErrors.title" class="mt-1.5">
                <div v-for="error in validationErrors.title">
                    <div class="text-red-600 text-sm">
                        {{ error }}
                    </div>
                </div>
            </div>
        </div>
        <div class="mr-2">
            <button @click="updateTitle" class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl">сохранить</button>
        </div>
        <div class="my-auto">
            <button @click="editTitle"><pencil-square-icon class="w-5 h-5"></pencil-square-icon></button>
        </div>
    </div>
    <div v-else class="mb-3">
        <div class="text-center text-2xl">{{ course.title }}
            <button v-if="authStore.user.role === 'teacher'" @click="editTitle"><pencil-square-icon class="w-4"></pencil-square-icon></button>
        </div>
    </div>


    <div v-if="course.chat_id" class="mb-5">
        <router-link class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl" :to="{name: 'chat', params: {'id': course.chat_id}}" >Открыть чат курса</router-link>
    </div>


    <div v-if="authStore.user.role === 'teacher'">
        <div v-if="studentAdd" class="flex mb-5">
            <div class="mr-2">
                <div class="md:flex">
                    <label class="flex items-center" for="studentEmail">Введите email студента:</label>
                    <input v-model="studentEmail" type="text" class="mb-2 ml-2 border rounded-lg p-1 pl-3" id="studentEmail" :placeholder="studentEmail">
                    <div>
                        <button @click="addStudent" class="mb-2 ml-2 bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl">добавить</button>
                    </div>
                    <div>
                        <button class="mb-2 ml-2 bg-red-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl" @click="addingStudent">отмена</button>
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
        <div v-else class="mb-5">
            <button  class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl" @click.prevent="addingStudent">Добавить ученика</button>
        </div>
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
            <div class="flex">
                <div class="border rounded-2xl cursor-pointer hover:shadow-xl p-5 flex">
                    {{ student.name }}
                    <div v-if="authStore.user.role === 'teacher'">
                        <div v-if="studentRemoveId === student.id" class="ml-10">
                            <button @click="removeStudent(student.email)" class="bg-red-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl">Подтвердить удаление</button>
                            <button @click="cancelRemoveStudent()" class="ml-2 bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl">Отмена</button>
                        </div>
                        <div v-else class="ml-10">
                            <button v-if="authStore.user.role === 'teacher'" @click="removingStudent(student.id)" class="bg-red-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl">Удалить</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


</template>

<script>
import {PencilSquareIcon} from "@heroicons/vue/24/outline"
import {mapStores} from "pinia";
import {useAuthStore} from "../../stores/auth";


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
            studentRemoveId: null
        }
    },
    computed: {
      ...mapStores(useAuthStore)
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
            this.newTitle = this.course.title
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
                })
            }).catch(({response}) => {
                if (response.status === 422) {
                    this.validationErrors = response.data.errors;
                }
            });
        },
        removingStudent(studentRemoveId) {
            this.studentRemoveId = studentRemoveId
        },
        removeStudent(studentEmail) {
            axios.post(`/api/courses/${this.course.id}/remove-student`, {email: studentEmail}).then(() => {
                axios.get(`/api/courses/${this.course.id}`).then((data) => {
                    this.course = data.data.data
                    this.studentAdd = false;
                })
            });
        },
        cancelRemoveStudent() {
            this.studentRemoveId = null
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <div class="flex flex-col">
        <label for="title" class="mb-2 pl-3">Название урока</label>
        <div class="mb-5">
            <input v-model="title" type="text" class="border rounded-lg p-1.5 pl-3" id="title">
            <div v-if="validationErrors.title" class="mt-1.5">
                <div v-for="error in validationErrors.title">
                    <div class="text-red-600 text-sm">
                        {{ error }}
                    </div>
                </div>
            </div>
        </div>

        <label for="content" class="mb-2 pl-3">Контент</label>
        <div class="mr-5">
            <text-editor v-model="content"></text-editor>
        </div>



        <div>
            <button @click.prevent="store" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-2xl">Создать урок</button>
        </div>
    </div>
</template>

<script>
import router from "../../../router";
import TextEditor from "../../TextEditor/TextEditor.vue";

export default {
    name: "Store",
    components: {
        TextEditor
    },
    data() {
        return {
            title: '',
            validationErrors: {},
            content: ''
        }
    },
    mounted() {

    },
    methods: {
        store() {
            let imagePaths = Array.from(new DOMParser().parseFromString(this.content, 'text/html').querySelectorAll('img')).map(img => img.getAttribute('src'));
            axios.post(`/api/courses/${this.$route.params.course_id}/lessons`, {'title': this.title, 'content': this.content, 'imagePaths': imagePaths}).then(() => {
                router.push({name: 'courses.show', params: {id: this.$route.params.course_id}});
            })
        }
    }
}
</script>

<style>
.ck-editor__editable {
    min-height: 500px;
    word-break: break-word;
}
</style>

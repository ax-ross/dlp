<template>
    <p class="text-2xl">Создание курса</p>
    <div class="flex flex-col">
        <label for="title" class="mb-2 pl-3">Название курса</label>
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

        <div>
            <button @click.prevent="store" class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl">Создать курс</button>
        </div>
    </div>

</template>

<script>
import router from "../../router";

export default {
    name: "Create",
    data () {
        return {
            title: '',
            validationErrors: {}
        }
    },
    methods: {
        store() {
            axios.post('/api/courses', {'title': this.title}).then(() => {
                router.push({name: 'courses'});
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

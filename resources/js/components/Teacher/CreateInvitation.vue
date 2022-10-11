<template>
    <div class="container flex">
        <div class="row">
            <div class="mt-10">
                <span class="font-bold">Создать приглашение</span>
                <div class="flex flex-col mb-3">
                    <label for="email" class="mb-2 pl-3">Email</label>
                    <input v-model="email" type="email" class="border rounded-lg p-1.5 pl-3" id="email">
                </div>
                <button class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl" @click.prevent="createInvitation">Создать</button>
                <div v-if="code">
                    {{ code }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CreateInvitation",
    data () {
        return {
            email: '',
            code: ''
        }
    },
    methods: {
        createInvitation()
        {
            axios.post('/api/teacher/invitations', {email: this.email}).then(res => {
                this.code = res.data.data['code'];
            })
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <div class="container w-50 mt-5">
        <div class="row">
            <div class="col-md-6">
                Создать приглашение
                <div class="mb-3">
                    <label for="email" class="form-label">Email (Необязательно)</label>
                    <input v-model="email" type="email" class="form-control" name="email" id="email">
                </div>
                <button class="btn btn-primary" @click="createInvitation">Создать</button>
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
            axios.post('/teachers/invitations', {email: this.email}).then(res => {
                this.code = res.data.data['code'];
            })
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <div class="container register d-flex justify-content-center align-items-center">
        <div class="row col-lg-4 col-md-6">
            <form :action=registerRoute class="p-5" method="POST">
                <p class="fw-bold text-center fs-4">Регистрация</p>
                <div class="mb-3">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                </div>
                <div class="form-check">
                    <input type="radio" v-model="role" class="form-check-input" name="role" id="role-teacher" value="teacher">
                    <label for="role-teacher" class="form-check-label">Я учитель</label>
                </div>
                <div class="form-check mb-4">
                    <input type="radio" v-model=role class="form-check-input" name="role" id="role-student" value="student">
                    <label for="role-student" class="form-check-label">Я ученик</label>
                </div>
                <div class="mb-4" v-if="role === 'student'">
                    <label for="invitation_code" class="form-label">Пригласительный код</label>
                    <input type="text" class="form-control" name="invitation_code" id="invitation_code">
                </div>
                <input type="hidden" name="_token" :value="csrf">
                <div class="text-end mb-5">
                    <button type="submit" class="btn btn-outline-primary">Зарегестрироваться</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "RegisterForm",
    props: ['registerRoute'],
    data() {
      return {
          role: ''
      }
    },
    computed: {
        csrf() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }
    }
}
</script>

<style scoped>
.register{
    height: 100vh;
}
.register form {
    box-shadow: 0 0 30px 0 #05113F33;
    border-radius: 5px;
}
</style>

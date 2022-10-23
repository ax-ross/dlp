<template>
    <div>Главная страница студента</div>
</template>

<script>
export default {
    name: "Index",
    mounted() {
        this.test()
    },
     methods: {
        test() {
            axios.get('/api/users/').then((data) => {
                console.log(data);
            })
        }
     }
}
</script>

<style scoped>

</style>

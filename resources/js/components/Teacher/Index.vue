<template>
    <div>Главная страница учителя</div>
    <div>
        <router-link :to="{ name: 'chats' }" class="text-blue-400">Чаты</router-link>
        <router-link :to="{ name: 'courses' }" class="text-blue-400">Курсы</router-link>
    </div>
</template>

<script>

export default {
    name: "Index",
}
</script>

<style scoped>

</style>

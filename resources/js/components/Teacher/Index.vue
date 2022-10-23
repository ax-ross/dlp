<template>
    <div>Главная страница учителя</div>
    <div>
        <router-link :to="{ name: 'rooms' }" class="text-blue-400">Чаты</router-link>
    </div>
</template>

<script>

export default {
    name: "Index",
}
</script>

<style scoped>

</style>

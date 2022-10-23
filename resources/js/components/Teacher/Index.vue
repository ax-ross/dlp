<template>
    <div>Главная страница учителя</div>
    <create-invitation></create-invitation>
    <div>
        <router-link :to="{ name: 'rooms' }" class="text-blue-400">Чаты</router-link>
    </div>
</template>

<script>
import CreateInvitation from "./CreateInvitation.vue";

export default {
    name: "Index",
    components: {
        CreateInvitation,
    }
}
</script>

<style scoped>

</style>

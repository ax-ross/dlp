<template>
    <div>Главная страница учителя</div>
    <create-invitation></create-invitation>
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

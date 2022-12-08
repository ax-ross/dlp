<template>
    <div class="container flex">

    </div>
</template>

<script>

import {useAuthStore} from "../../../stores/auth";
import {mapStores} from "pinia";

export default {
    name: "Chat",
    data() {
        return {
            sub: null
        }
    },
    computed: {
        ...mapStores(useAuthStore)
    },
    methods: {
        subscribeChat() {
            this.sub =  centrifuge.newSubscription(`personal:user#${this.authStore.user.id}`);
            this.sub.on('publication', this.updateChat()).subscribe()
        },
        updateChat() {
            axios.get(`/api/`)
        }
    }
}
</script>

<style scoped>

</style>

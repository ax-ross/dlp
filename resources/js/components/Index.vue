<template>
    <div class="flex min-h-screen">
        <Sidebar>
        </Sidebar>
        <div class="flex-1 mt-5 ml-5">
            <div v-if="$route.name === 'index'">
                Main page content
            </div>
            <router-view></router-view>
        </div>
    </div>


</template>

<script>
import Sidebar from "./Sidebar/Sidebar.vue";
import {useAuthStore} from "../stores/auth";
import {mapStores} from "pinia";

export default {
    name: "Index",
    components: {
        Sidebar
    },
    computed: {
        ...mapStores(useAuthStore)
    }

}
</script>

<style scoped>

</style>

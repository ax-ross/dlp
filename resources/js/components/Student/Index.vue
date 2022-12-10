<template>
    <div class="flex min-h-screen">
        <Sidebar>
            <StudentSidebarNavigation></StudentSidebarNavigation>
        </Sidebar>
        <div class="flex-1 mt-5 ml-5">
            <div v-if="currentRouteName === 'student'">
                Главная
            </div>
            <router-view></router-view>
        </div>
    </div>

</template>

<script>
import Sidebar from "../Sidebar/Sidebar.vue";
import {mapStores} from "pinia";
import {useAuthStore} from "../../stores/auth";
import StudentSidebarNavigation from "../Sidebar/StudentSidebarNavigation.vue";

export default {
    name: "Index",
    components: {
        Sidebar,
        StudentSidebarNavigation
    },
    computed: {
        currentRouteName() {
            return  this.$route.name
        },
        ...mapStores(useAuthStore),
    },
}
</script>

<style scoped>

</style>

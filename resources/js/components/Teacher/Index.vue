<template>
    <div class="flex min-h-screen">
        <Sidebar>
            <TeacherSidebarNavigation></TeacherSidebarNavigation>
        </Sidebar>
        <div class="flex-1 mt-5 ml-5">
            <div v-if="currentRouteName === 'teacher'">
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
import TeacherSidebarNavigation from "../Sidebar/TeacherSidebarNavigation.vue";

export default {
    name: "Index",
    components: {
        Sidebar,
        TeacherSidebarNavigation
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

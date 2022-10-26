<template>
    <div class="mb-10">
        <div v-for="navItem in navigation">
            <router-link :to="{ name: navItem.route }" class="flex text-center px-6 py-2.5 text-gray-500 hover:text-sky-600 group">
                <component :is="navItem.icon" class="h-6 w-5 text-gray-400 mr-2 group-hover:text-sky-500"></component>
                <div v-if="!sidebarStore.collapsed">
                    {{ navItem.name }}
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
import {AcademicCapIcon, ChatBubbleLeftIcon, HomeIcon} from "@heroicons/vue/24/outline";
import {mapStores} from "pinia";
import {useSidebarStore} from "../../stores/sidebar";

export default {
    name: "TeacherSidebarNavigation",
    computed: {
        ...mapStores(useSidebarStore)
    },
    data() {
        return {
            navigation: [
                {name: 'Главная', route: 'teacher', icon: HomeIcon},
                {name: 'Курсы', route: 'teacher.courses', icon: AcademicCapIcon},
                {name: 'Чаты', route: 'teacher.chats', icon: ChatBubbleLeftIcon},
            ],
        }
    },
}
</script>

<style scoped>

</style>

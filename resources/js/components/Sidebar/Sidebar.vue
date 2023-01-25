<template>
    <div class="w-64 bg-gray-50 border-r border-gray-200" :class="{ 'w-20': sidebarStore.collapsed }">
        <div class="py-4 px-6">
            <button class="flex" @click="sidebarStore.toggleSidebar()">
                <ChevronDoubleLeftIcon class="h-6 w-6" :class="{'rotate-180': sidebarStore.collapsed}"></ChevronDoubleLeftIcon>
            </button>
        </div>

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

    </div>
</template>

<script>
import {AcademicCapIcon, ChevronDoubleLeftIcon, HomeIcon} from '@heroicons/vue/24/outline';
import { useSidebarStore } from "../../stores/sidebar";
import { mapStores } from 'pinia';

export default {
    name: "Sidebar",
    computed: {
        ...mapStores(useSidebarStore)
    },
    components: {
        ChevronDoubleLeftIcon
    },
    data() {
        return {
            navigation: [
                {name: 'Главная', route: 'index', icon: HomeIcon},
                {name: 'Курсы', route: 'courses', icon: AcademicCapIcon}
            ]
        }
    }
}
</script>

<style>
</style>

<style scoped>
</style>

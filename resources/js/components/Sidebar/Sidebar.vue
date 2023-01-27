<template>
    <div class="w-64 bg-gray-50 border-r border-gray-200" :class="{ 'w-20': sidebarStore.collapsed }">
        <div class="py-4 px-6">
            <button class="flex" @click="sidebarStore.toggleSidebar()">
                <ChevronDoubleLeftIcon class="h-6 w-6"
                                       :class="{'rotate-180': sidebarStore.collapsed}"></ChevronDoubleLeftIcon>
            </button>
        </div>

        <div class="mb-10">
            <div v-for="navItem in navigation">
                <router-link :to="{ name: navItem.route }"
                             class="flex text-center px-6 py-2.5 text-gray-500 hover:text-sky-600 group">
                    <component :is="navItem.icon"
                               class="h-6 w-5 text-gray-400 mr-2 group-hover:text-sky-500"></component>
                    <div v-if="!sidebarStore.collapsed">
                        {{ navItem.name }}
                    </div>
                </router-link>
            </div>
        </div>

        <div class="flex text-center px-6 py-2.5 hover:text-sky-600 group" style="position: absolute; bottom: 20px">
            <div v-if="!sidebarStore.collapsed">
                <button @click="logout" class="bg-red-500 text-white p-3 border rounded-2xl">Выйти</button>
            </div>
            <div v-else>
                <ArrowLeftOnRectangleIcon @click="logout"
                                          class="h-6 w-5 text-gray-400 mr-2 group-hover:text-red-500"></ArrowLeftOnRectangleIcon>
            </div>
        </div>

    </div>
</template>

<script>
import {AcademicCapIcon, ChevronDoubleLeftIcon, HomeIcon, ArrowLeftOnRectangleIcon} from '@heroicons/vue/24/outline';
import {useSidebarStore} from "../../stores/sidebar";
import {mapStores} from 'pinia';
import axios from "axios";
import router from "../../router";
import {useAuthStore} from "../../stores/auth";

export default {
    name: "Sidebar",
    computed: {
        ...mapStores(useSidebarStore, useAuthStore)
    },
    components: {
        ChevronDoubleLeftIcon,
        ArrowLeftOnRectangleIcon
    },
    data() {
        return {
            navigation: [
                {name: 'Главная', route: 'index', icon: HomeIcon},
                {name: 'Курсы', route: 'courses', icon: AcademicCapIcon}
            ]
        }
    },
    methods: {
        logout() {
            axios.post('/logout').then(() => {
                this.authStore.removeAuthUserFromStore();
                router.push({name: 'welcome'});
            })
        }
    }
}
</script>

<style>
</style>

<style scoped>
</style>

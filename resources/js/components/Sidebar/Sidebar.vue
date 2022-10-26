<template>
    <div class="w-64 bg-gray-50 border-r border-gray-200" :class="{ 'w-20': sidebarStore.collapsed }">
        <div class="py-4 px-6">
            <button class="flex" @click="sidebarStore.toggleSidebar()">
                <ChevronDoubleLeftIcon class="h-6 w-6" :class="{'rotate-180': sidebarStore.collapsed}"></ChevronDoubleLeftIcon>
            </button>
        </div>
        <slot></slot>
    </div>
</template>

<script>
import { ChevronDoubleLeftIcon } from '@heroicons/vue/24/outline';
import { useSidebarStore } from "../../stores/sidebar";
import { mapStores } from 'pinia';

export default {
    name: "Sidebar",
    computed: {
        ...mapStores(useSidebarStore)
    },
    components: {
        ChevronDoubleLeftIcon
    }
}
</script>

<style>
</style>

<style scoped>
</style>

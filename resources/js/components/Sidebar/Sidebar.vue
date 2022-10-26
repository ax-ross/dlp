<template>
    <div class="w-64 bg-gray-50 border-r border-gray-200">
        <div class="py-4 px-6">
            <button class="flex">
                <ChevronDoubleLeftIcon class="h-6 w-6"></ChevronDoubleLeftIcon>
                Dashboard
            </button>
        </div>
        <slot></slot>
    </div>
</template>

<script>
import { ChevronDoubleLeftIcon } from '@heroicons/vue/24/outline';
export default {
    name: "Sidebar",
    components: {
        ChevronDoubleLeftIcon
    }
}
</script>

<style>
</style>

<style scoped>
</style>

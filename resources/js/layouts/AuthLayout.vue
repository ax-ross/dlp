<template>
    <div class="min-h-screen container flex justify-center items-center flex-col mx-auto">
        <div class="shadow-2xl md:p-10 sm:p-5 p-2.5 w-4/5 sm:w-3/5 md:w-3/5 lg:w-5/12 xl:w-1/3">
            <router-link :to="{ name: 'index' }" class="text-blue-400 text-sm">На главную</router-link>
            <slot></slot>
        </div>

    </div>
</template>

<script>
export default {
    name: "AuthLayout"
}
</script>

<style scoped>

</style>

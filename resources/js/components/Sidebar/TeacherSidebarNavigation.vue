<template>
    <div v-for="section in navigation">
        <div class="mb-10">
            <p class="mx-6 mb-2 text-xs text-gray-400 uppercase tracking-widest">
                {{ section.name }}
            </p>
            <div v-for="navItem in section.nestedNav">
                <router-link :to="{ name: navItem.routeName }" class="flex text-center px-6 py-2.5 text-gray-500 hover:text-sky-600 group">
                    <component :is="navItem.icon" class="h-5 w-5 text-gray-400 mr-2 group-hover:text-sky-500"></component>
                    {{ navItem.name }}
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import {AcademicCapIcon, ChatBubbleLeftIcon, HomeIcon} from "@heroicons/vue/24/outline";

export default {
    name: "TeacherSidebarNavigation",
    data() {
        return {
            navigation: [
                {name: 'Главная', nestedNav: [{routeName: 'teacher', icon: HomeIcon, name: 'Главная'}, {routeName: 'teacher', icon: HomeIcon, name: 'Главная'}, {routeName: 'teacher', icon: HomeIcon, name: 'Главная'}]},
                {name: 'Курсы', nestedNav: [{routeName: 'teacher.courses', icon: AcademicCapIcon, name: 'Курсы'}, {routeName: 'teacher.courses', icon: AcademicCapIcon, name: 'Курсы'}, {routeName: 'teacher.courses', icon: AcademicCapIcon, name: 'Курсы'}]},
                {name: 'Чаты', nestedNav: [{routeName: 'teacher.chats', icon: ChatBubbleLeftIcon, name: 'Чаты'}, {routeName: 'teacher.chats', icon: ChatBubbleLeftIcon, name: 'Чаты'}, {routeName: 'teacher.chats', icon: ChatBubbleLeftIcon, name: 'Чаты'}]}
            ],
        }
    },
}
</script>

<style scoped>

</style>

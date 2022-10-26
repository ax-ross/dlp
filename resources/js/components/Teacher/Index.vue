<template>

<!--    <div class="relative flex min-h-screen">-->
<!--        <div class="bg-cyan-600 text-cyan-100 w-64 px-2 py-4 absolute inset-y-0 left-0 transform">-->
<!--            <sidebar>-->
<!--                <div>-->
<!--                    <router-link :to="{ name: 'teacher' }" class="flex item-center p-3 px-4 hover:bg-cyan-700"> <HomeIcon class="w-5 h-5"></HomeIcon> На главную</router-link>-->
<!--                </div>-->
<!--                <div>-->
<!--                    <router-link :to="{ name: 'teacher.chats' }" class="flex item-center p-3 px-4 hover:bg-cyan-700"> <ChatBubbleLeftIcon class="w-5 h-5 "></ChatBubbleLeftIcon> Чаты</router-link>-->
<!--                </div>-->
<!--                <div>-->
<!--                    <router-link :to="{ name: 'teacher.courses' }" class="flex item-center p-3 px-4 hover:bg-cyan-700"><AcademicCapIcon class="w-5 h-5 "></AcademicCapIcon> Курсы</router-link>-->
<!--                </div>-->
<!--            </sidebar>-->
<!--        </div>-->
<!--        <div class="flex-1">-->
<!--            <div v-if="currentRouteName === 'teacher'">-->
<!--                <div>Главная страница учителя</div>-->

<!--                <div>-->
<!--                    <router-link :to="{ name: 'teacher.chats' }" class="text-blue-400">Чаты</router-link>-->
<!--                    <router-link :to="{ name: 'teacher.courses' }" class="text-blue-400">Курсы</router-link>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="p-8">-->
<!--                <router-view></router-view>-->
<!--            </div>-->
<!--        </div>-->


<!--    </div>-->


    <div class="flex min-h-screen">
        <div class="w-64 bg-gray-50 border-r border-gray-200">
            <div class="py-4 px-6">
                <button class="flex">
                    <ChevronDoubleLeftIcon class="h-6 w-6"></ChevronDoubleLeftIcon>
                    Dashboard
                </button>
            </div>

            <div class="mb-10">
                <p class="mx-6 mb-2 text-xs text-gray-400 uppercase tracking-widest">
                    Главная
                </p>
                <router-link :to="{ name: 'teacher' }" class="flex text-center px-6 py-2.5 text-gray-500 hover:text-sky-600 group">
                    <HomeIcon class="h-5 w-5 text-gray-400 mr-2 group-hover:text-sky-500"></HomeIcon>
                    На главную
                </router-link>
                <router-link :to="{ name: 'teacher' }" class="flex text-center px-6 py-2.5 text-gray-500 hover:text-sky-600 group">
                    <HomeIcon class="h-5 w-5 text-gray-400 mr-2 group-hover:text-sky-500"></HomeIcon>
                    На главную
                </router-link>
                <router-link :to="{ name: 'teacher' }" class="flex text-center px-6 py-2.5 text-gray-500 hover:text-sky-600 group">
                    <HomeIcon class="h-5 w-5 text-gray-400 mr-2 group-hover:text-sky-500"></HomeIcon>
                    На главную
                </router-link>
            </div>

            <div class="mb-10">
                <p class="mx-6 mb-2 text-xs text-gray-400 uppercase tracking-widest">
                    Курсы
                </p>
                <router-link :to="{ name: 'teacher.courses' }" class="flex text-center px-6 py-2.5 text-gray-500 hover:text-sky-600 group">
                    <AcademicCapIcon class="h-5 w-5 text-gray-400 mr-2 group-hover:text-sky-500"></AcademicCapIcon>
                    Мои курсы
                </router-link>
                <router-link :to="{ name: 'teacher.courses' }" class="flex text-center px-6 py-2.5 text-gray-500 hover:text-sky-600 group">
                    <AcademicCapIcon class="h-5 w-5 text-gray-400 mr-2 group-hover:text-sky-500"></AcademicCapIcon>
                    Мои курсы
                </router-link>
                <router-link :to="{ name: 'teacher.courses' }" class="flex text-center px-6 py-2.5 text-gray-500 hover:text-sky-600 group">
                    <AcademicCapIcon class="h-5 w-5 text-gray-400 mr-2 group-hover:text-sky-500"></AcademicCapIcon>
                    Мои курсы
                </router-link>
            </div>
            <div class="mb-10">
                <p class="mx-6 mb-2 text-xs text-gray-400 uppercase tracking-widest">
                    Чаты
                </p>
                <router-link :to="{ name: 'teacher.chats' }" class="flex text-center px-6 py-2.5 text-gray-500 hover:text-sky-600 group">
                    <ChatBubbleLeftIcon class="h-5 w-5 text-gray-400 mr-2 group-hover:text-sky-500"></ChatBubbleLeftIcon>
                    Мои чаты
                </router-link>
                <router-link :to="{ name: 'teacher.chats' }" class="flex text-center px-6 py-2.5 text-gray-500 hover:text-sky-600 group">
                    <ChatBubbleLeftIcon class="h-5 w-5 text-gray-400 mr-2 group-hover:text-sky-500"></ChatBubbleLeftIcon>
                    Мои чаты
                </router-link>
                <router-link :to="{ name: 'teacher.chats' }" class="flex text-center px-6 py-2.5 text-gray-500 hover:text-sky-600 group">
                    <ChatBubbleLeftIcon class="h-5 w-5 text-gray-400 mr-2 group-hover:text-sky-500"></ChatBubbleLeftIcon>
                    Мои чаты
                </router-link>
            </div>
        </div>
        <div class="flex-1">
            <div v-if="currentRouteName === 'teacher'">
                Главная
            </div>
            <router-view></router-view>
        </div>
    </div>

</template>

<script>
import Sidebar from "../Sidebar/Sidebar.vue";
import {Centrifuge} from "centrifuge";
import {mapStores} from "pinia";
import {useAuthStore} from "../../stores/auth";
import {HomeIcon} from "@heroicons/vue/24/outline";
import {ChatBubbleLeftIcon} from '@heroicons/vue/24/outline';
import {AcademicCapIcon} from '@heroicons/vue/24/outline';
import {ChevronDoubleLeftIcon} from "@heroicons/vue/24/outline";

export default {
    name: "Index",
    components: {
        Sidebar,
        HomeIcon,
        ChatBubbleLeftIcon,
        AcademicCapIcon,
        ChevronDoubleLeftIcon
    },

    computed: {
        currentRouteName() {
            return  this.$route.name
        },
        ...mapStores(useAuthStore),
    },
    methods: {
      connectChat() {
          const centrifuge = new Centrifuge('ws://127.0.0.1:8000/connection/websocket', {
              debug: true,
              timeout: 20000
          });

          centrifuge.on('connecting', function (ctx) {
              console.log(`connecting: ${ctx.code}, ${ctx.reason}`);
          }).on('connected', function (ctx) {
              console.log(`connected over ${ctx.transport}`);
          }).on('disconnected', function (ctx) {
              console.log(`disconnected: ${ctx.code}, ${ctx.reason}`);
          }).connect();
          const sub = centrifuge.newSubscription("personal:user#" + this.authStore.user.id);
          sub.on('publication', function (ctx) {
              console.log('НОВОЕ СООБЩЕНИЕ')
              console.log(ctx);
          }).on('subscribing', function (ctx) {
              console.log(`subscribing: ${ctx.code}, ${ctx.reason}`);
          }).on('subscribed', function (ctx) {
              console.log('subscribed', ctx);
          }).on('unsubscribed', function (ctx) {
              console.log(`unsubscribed: ${ctx.code}, ${ctx.reason}`);
          }).subscribe();
      }
    },
    mounted() {
        this.connectChat()
    }
}
</script>

<style scoped>

</style>

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
import {Centrifuge} from "centrifuge";
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
    methods: {
      connectChat() {
          const centrifuge = new Centrifuge('ws://127.0.0.1:8000/connection/websocket', {
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

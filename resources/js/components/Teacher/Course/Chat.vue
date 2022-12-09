<template>
    <div class="container flex flex-col">
        <div>
            Чат {{ chat.title }}
        </div>
        <div v-if="chat.users">
            Участников {{ chat.users.length}}
        </div>
        <div v-for="message in chat.messages">
            <div>
                Отправитель: {{ message.user.name }}
            </div>
            <div>
                Сообщение: {{ message.message }}
            </div>
        </div>
        <div class="mt-2">
            <textarea v-model="messageToSend" class="border rounded-lg p-1.5 pl-3"></textarea>
            <button class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl" type="submit" @click.prevent="sendMessage">Отправить</button>
        </div>
    </div>
</template>

<script>

import {useAuthStore} from "../../../stores/auth";
import {mapStores} from "pinia";
import {Centrifuge} from "centrifuge";

export default {
    name: "Chat",
    data() {
        return {
            sub: null,
            chat: {},
            messageToSend: ''
        }
    },
    created() {
        this.updateChat()
        this.subscribeChat()
    },
    computed: {
        ...mapStores(useAuthStore)
    },
    methods: {
        subscribeChat() {
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


            this.sub =  centrifuge.newSubscription(`personal:user#${this.authStore.user.id}`);
            this.sub.on('publication', () => {
                console.log('НОВОЕ СООБЩЕНИЕ')
                this.updateChat();
            })
            this.sub.subscribe();
        },
        updateChat() {
            axios.get(`/api/courses/${this.$route.params.id}/chat`).then((data) => {
                console.log(data.data[0])
                this.chat = data.data[0]
            })
        },
        sendMessage() {
            axios.post(`/api/rooms/${this.chat.id}/publish`, {message: this.messageToSend}).then(() => {
                this.updateChat()
            })
        }
    }
}
</script>

<style scoped>

</style>

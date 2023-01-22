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
        axios.get(`/api/courses/${this.$route.params.id}/chat`).then((data) => {
            this.chat = data.data.data
        })
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

            centrifuge.connect();

            this.sub =  centrifuge.newSubscription(`personal:user#${this.authStore.user.id}`);
            this.sub.on('publication', (publication) => {
                this.chat.messages.push(publication.data)

            })
            this.sub.subscribe();
        },
        sendMessage() {
            axios.post(`/api/chats/${this.chat.id}/publish`, {message: this.messageToSend}).then(() => {
                this.messageToSend = '';
            })
        }
    }
}
</script>

<style scoped>

</style>

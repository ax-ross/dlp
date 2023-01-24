<template>
    <div class="container flex flex-col">
    </div>

    <div class="container bg-slate-200 p-8 m-8 border rounded-2xl w-4/5">
        <div class="text-3xl text-center">
            {{ chat.title }}
        </div>
        <div v-if="chat.users" class="text-xl flex">
            Участников: {{ chat.users.length }}
        </div>
        <div class="bg-white border rounded-2xl p-8 overflow-y-auto h-[36rem] " ref="chat">
            <div v-for="message in chat.messages">
                <div v-if="authStore.user.id === message.user.id" class="flex">
                    <div class="bg-green-300 bg-opacity-25 ml-auto w-80 break-words p-3 m-3 border rounded-2xl">
                        <div class="flex font-bold content-center mb-2">
                            <img :src="message.user.avatar" alt="" style="width: 50px; height: 50px;" class="border rounded-full float-left mr-5">
                            <div class="flex items-center">
                                {{ message.user.name }}
                            </div>
                        </div>
                        <div>
                            {{ message.message }}
                        </div>

                    </div>
                </div>
                <div v-else class="flex">
                    <div class="bg-sky-200 bg-opacity-25 w-80 break-words p-3 m-3 border rounded-2xl">
                        <div>
                            Отправитель: {{ message.user.name }}
                        </div>
                        <div>
                            Сообщение: {{ message.message }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="mt-2 flex">
            <textarea v-model="messageToSend" class="border rounded-lg p-1.5 pl-3 w-full"></textarea>
            <button class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl" type="submit"
                    @click.prevent="sendMessage">Отправить
            </button>
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

            this.sub = centrifuge.newSubscription(`personal:user#${this.authStore.user.id}`);
            this.sub.on('publication', (publication) => {
                this.chat.messages.push(publication.data)
            })
            this.sub.subscribe();
        },
        sendMessage() {
            axios.post(`/api/chats/${this.chat.id}/publish`, {message: this.messageToSend}).then(() => {
                this.messageToSend = '';
            })
        },
    },
    watch: {
        'chat.messages': {
            handler() {
                const chatEl = this.$refs.chat;
                if (chatEl) {
                    setTimeout(() => {
                        chatEl.scrollTop = chatEl.scrollHeight
                    })
                }
            },
            deep: true
        }
    }
}
</script>

<style scoped>

</style>

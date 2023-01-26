<template>
    <div class="container flex flex-col">
    </div>

    <div class="container bg-slate-200 p-8 m-8 border rounded-2xl w-4/5">
        <div class="text-3xl text-center">
            {{ chat.title }}
        </div>
        <div v-if="chat.users_count" class="text-xl flex">
            Участников: {{ chat.users_count }}
        </div>
        <div class="bg-white border rounded-2xl p-8 overflow-y-auto h-[36rem] " ref="chat">
            <div class="sentinel" ref="sentinel" style="height: 0"></div>
            <div v-for="message in messages">
                <div v-if="authStore.user.id === message.user.id" class="flex">
                    <div class="bg-green-300 bg-opacity-25 ml-auto w-80 break-words p-3 m-3 border rounded-2xl">
                        <div class="flex font-bold content-center mb-2">
                            <img :src="message.user.avatar" alt="" style="width: 50px; height: 50px;"
                                 class="border rounded-full float-left mr-5">
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
                        <div class="flex font-bold content-center mb-2">
                            <img :src="message.user.avatar" alt="" style="width: 50px; height: 50px;"
                                 class="border rounded-full float-left mr-5">
                            <div class="flex items-center">
                                {{ message.user.name }}
                            </div>
                        </div>
                        <div>
                            {{ message.message }}
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

import {useAuthStore} from "../../stores/auth";
import {mapStores} from "pinia";
import {Centrifuge} from "centrifuge";

export default {
    name: "Chat",
    data() {
        return {
            chat: {},
            messages: [],
            messageToSend: '',
            currentPage: 1,
            lastPage: 1,
        }
    },
    created() {
        this.getChat();
        this.subscribeChat();
        this.loadMessage();
    },
    destroyed() {
        if (this.listEndObserver) {
            this.listEndObserver.disconnect();
        }
    },
    methods: {
        getChat() {
            axios.get(`/api/chats/${this.$route.params.id}`).then((data) => {
                this.chat = data.data.data
            })
        },
        subscribeChat() {
            const centrifuge = new Centrifuge('ws://127.0.0.1:8000/connection/websocket', {
                timeout: 20000
            });

            centrifuge.connect();

            this.sub = centrifuge.newSubscription(`personal:user#${this.authStore.user.id}`);
            this.sub.on('publication', (message) => {
                this.messages.push(message.data)
                this.scrollDown()
            })
            this.sub.subscribe();
        },
        loadMessage() {
            axios.get(`/api/chats/${this.$route.params.id}/messages?page=${this.currentPage}`).then((data) => {
                this.messages.push(...data.data.data)
                this.currentPage = data.data.meta.current_page
                this.lastPage = data.data.meta.last_page
                this.scrollDown();
                this.setUpInterSectionObserver();
            })
        },
        scrollDown() {
            this.$nextTick().then(() => {
                let chatEl = this.$refs.chat;
                chatEl.scrollTop = chatEl.scrollHeight
            })
        },
        sendMessage() {
            axios.post(`/api/chats/${this.chat.id}/publish`, {message: this.messageToSend}).then(() => {
                this.messageToSend = '';
            })
        },
        recordScrollPosition() {
            let chat = this.$refs.chat;
            this.previousScrollHeightMinusScrollTop =
                chat.scrollHeight - chat.scrollTop;
        },
        restoreScrollPosition() {
            let chat = this.$refs.chat;
            chat.scrollTop = chat.scrollHeight - this.previousScrollHeightMinusScrollTop
        },
        setUpInterSectionObserver() {
            let options = {
                root: this.$refs.chat
            };
            this.listEndObserver = new IntersectionObserver(
                this.handleIntersection,
                options
            );
            this.listEndObserver.observe(this.$refs.sentinel)
        },
        handleIntersection([entry]) {
            if (entry.isIntersecting && (this.currentPage < this.lastPage)) {
                this.loadMoreMessages();
            }
        },
        async loadMoreMessages() {
            this.recordScrollPosition();
            await axios.get(`/api/chats/${this.$route.params.id}/messages?page=${this.currentPage + 1}`).then((data) => {
                this.messages.unshift(...data.data.data)
                this.currentPage = data.data.meta.current_page
                this.lastPage = data.data.meta.last_page
            })
            this.$nextTick().then(() => {
                this.restoreScrollPosition();
            })
        }

    },
    computed: {
        ...mapStores(useAuthStore)
    }
}
</script>

<style scoped>

</style>

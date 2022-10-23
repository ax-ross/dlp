<template>
    <div class="container">
        <div>
            <div class="flex flex-col mb-10">
                <label for="name" class="mb-2 pl-3">Название чата</label>
                <input v-model="name" type="text" class="border rounded-lg p-1.5 pl-3" id="name">
            </div>
            <div class="text-center mb-10">
                <button @click.prevent="createRoom()"  class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl">Создать</button>
            </div>
        </div>
    </div>
    <div class="container flex">
        <div class="chat-app">
            <div class="room-list">
                <ul v-for="room in rooms">
                    <li> <a href="" @click.prevent="getCurrentRoom(room.id)">Имя: {{  room.name }}</a>
                        <br>
                        Сообщений: {{ room.messages.length }}

                        <div v-if="currRoom">
                            <div v-if="currRoom.id === room.id">
                                <div>Число участников: {{ currRoom.users.length }}</div>
                                <div>Сообщения:</div>
                                <div class="mt-2" v-for="message in currRoom.messages">
                                    {{ message.user.name }} <br>
                                    {{ message.created_at }}
                                    <br>
                                    {{ message.message }}
                                </div>
                                <div class="mt-2">
                                    <textarea v-model="messageToSend" class="border rounded-lg p-1.5 pl-3"></textarea>
                                    <button class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-2xl" type="submit" @click.prevent="sendMessage(room.id)">Отправить</button>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="chat">

            </div>
        </div>
    </div>
</template>

<script>



import {useAuthStore} from "../../stores/auth";

export default {
    name: "Index",
    data() {
        return {
            name: '',
            rooms: [],
            currRoom: null,
            currRoomId: null,
            messageToSend: '',
        }
    },
    setup() {
        const authStore = useAuthStore();

        return  { authStore }
    },
    mounted() {
        this.getRooms();
        this.connectChat();
    },
    methods: {
        connectChat() {
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
        },
        createRoom() {
            axios.post('/api/rooms/', {'title': this.name}).then( (data) => {
            })
        },
        getRooms(){
            axios.get('/api/rooms/').then( (data) => {
                this.rooms = data.data;
            })
        },
        getCurrentRoom(roomId) {
            axios.get(`/api/rooms/${roomId}`).then( (data) => {
                this.currRoom = data.data;
            })
        },
        sendMessage(roomId) {
            axios.post(`/api/rooms/${roomId}/publish`, {message: this.messageToSend}).then( () => {
               this.getCurrentRoom(roomId);
            });
        },
    }
}
</script>

<style scoped>

</style>

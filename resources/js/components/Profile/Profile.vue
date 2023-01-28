<template>
    <div class="flex font-bold items-center text-xl">
        <img :src="user.avatar" alt="" class="w-32 h-32 border rounded-full mr-3">
        <div v-show="isEditing" ref="avatar-upload" class="w-[15rem] bg-black p-10 text-white cursor-pointer">
            Upload
        </div>
        <div v-if="!isEditing">
            <div class="mr-3">
                {{ user.name }}
            </div>
            <button @click="toggleEdit" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-2xl mr-3">Редактировать</button>
            <button class="bg-red-400 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-2xl">Удалить</button>
        </div>
        <div v-else>
            <input v-model="name" type="text" class="border rounded-lg p-1 pl-3" id="name">
            <div v-if="validationErrors.title" class="mt-1.5">
                <div v-for="error in validationErrors.title">
                    <div class="text-red-600 text-sm">
                        {{ error }}
                    </div>
                </div>
            </div>
            <button @click="updatedProfile  " class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-2xl mr-3">Сохранить</button>
            <button @click="toggleEdit" class="bg-red-400 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-2xl">Отмена</button>
        </div>
    </div>

</template>

<script>
import axios from "axios";
import {mapStores} from "pinia";
import {useAuthStore} from "../../stores/auth";
import Dropzone from "dropzone";

export default {
    name: "Profile",
    data() {
        return {
            user: {},
            isEditing: false,
            dropzone: {},
            validationErrors: {},
            name: ''
        }
    },
    computed: {
      ...mapStores(useAuthStore)
    },
    mounted() {
        this.user = this.authStore.user;
        this.name = this.user.name;
        this.dropzone = new Dropzone(this.$refs["avatar-upload"], {
            url: '/api/profile',
            autoProcessQueue: false,
            maxFiles: 1,
            addRemoveLinks: true
        })
    },
    methods: {
        toggleEdit(){
            this.isEditing = !this.isEditing;
        },
        updatedProfile() {
            let data = new FormData();
            if (this.dropzone.getAcceptedFiles()[0]) {
                data.append('avatar', this.dropzone.getAcceptedFiles()[0]);
            }
            data.append('name', this.name)
            axios.post('/api/profile', data)
        }
    }
}
</script>

<style scoped>

</style>

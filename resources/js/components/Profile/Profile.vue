<template>
    <div class="flex font-bold items-center text-xl">
        <img :src="user.avatar" alt="" class="w-32 h-32 border rounded-full mr-3">
        <input v-show="isEditing" type="file" @change.prevent="uploadAvatar" ref="avatar-upload">
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

export default {
    name: "Profile",
    data() {
        return {
            user: {},
            isEditing: false,
            validationErrors: {},
            name: '',
            newProfileData: {}
        }
    },
    computed: {
      ...mapStores(useAuthStore)
    },
    mounted() {
        this.user = this.authStore.user;
        this.name = this.user.name;
        this.newProfileData = new FormData();
    },
    methods: {
        toggleEdit(){
            this.isEditing = !this.isEditing;
        },
        uploadAvatar() {
            this.newProfileData.append('avatar', this.$refs['avatar-upload'].files[0])
        },
        updatedProfile() {
            this.newProfileData.append('name', this.name)
            axios.post('/api/profile', this.newProfileData)
        }
    }
}
</script>

<style scoped>

</style>

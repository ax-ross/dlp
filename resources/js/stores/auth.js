import { defineStore } from "pinia";

export const useAuthStore = defineStore('auth', {
    state: () => ({ authenticated: false, user: {} }),
    actions: {
        addAuthUserToStore() {
            return axios.get('/api/user').then(({data}) => {
                this.user = data;
                this.authenticated = true;
            }).catch(() => {
                this.user = {};
                this.authenticated = false;
            })
        },
        removeAuthUserFromStore() {
            this.user = {};
            this.authenticated = false;
        }
    }
})

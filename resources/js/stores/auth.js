import { defineStore } from "pinia";

export const useAuthStore = defineStore('auth', {
    state: () => ({ authenticated: false, user: {} }),
    getters: {
        authenticated: (state) => state.authenticated,
        user: (state) => state.user
    },
    actions: {
        login() {
            return axios.get('/api/user').then(({data}) => {
                this.user = data;
                this.authenticated = true;
            }).catch(() => {
                this.user = {};
                this.authenticated = false;
            })
        },
        logout() {
            this.user = {};
            this.authenticated = false;
        }
    }
})

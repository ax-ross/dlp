import { createRouter, createWebHistory } from "vue-router";
import App from "../components/App.vue";
import Index from "../components/Index.vue"

const routes = [
    {
      path: '/',
      name: 'index',
        component: Index
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../components/Auth/Register.vue')
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../components/Auth/Login.vue')
    },
    {
        path: '/teacher',
        name: 'teacher',
        component: () => import('../components/Teacher/Index.vue')
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export default router;

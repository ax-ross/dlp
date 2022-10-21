import { createRouter, createWebHistory } from "vue-router";
import App from "../components/App.vue";
import Index from "../components/Index.vue"
import { useAuthStore } from '../stores/auth'
import guest from "../middleware/guest";
import auth from "../middleware/auth";
import teacher from "../middleware/teacher";
import student from "../middleware/student";
import middlewarePipeline from "./middlewarePipeline";


const routes = [
    {
        path: '/',
        name: 'index',
        component: Index,
        meta: {
            middleware: [guest],
            title: 'Index'
        }
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../components/Auth/Register.vue'),
        meta: {
            middleware: [guest],
            title: 'Register'
        }
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../components/Auth/Login.vue'),
        meta: {
            middleware: [guest],
            title: 'Login'
        }
    },
    {
        path: '/teacher',
        name: 'teacher',
        component: () => import('../components/Teacher/Index.vue'),
        meta: {
            middleware: [auth, teacher],
            title: 'Teacher'
        }
    },
    {
        path: '/student',
        name: 'student',
        component: () => import('../components/Student/Index.vue'),
        meta: {
            middleware: [auth, student],
            title: 'Student'
        }
    },
    {
        path: '/chats',
        name: 'rooms',
        component: () => import('../components/Room/Index.vue'),
        meta: {
            middleware: [auth],
            title: 'Chats'
        }
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})


router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
    const middleware = to.meta.middleware;
    const context = { to, from, next, authStore };
    document.title = to.meta.title

    if (!middleware) {
        return next();
    }
    return middleware[0]({
        ...context,
        nextMiddleware: middlewarePipeline(context, middleware, 1),
    })
});

export default router;

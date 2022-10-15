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
    middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1),
    })

    // if (to.meta.middleware === 'auth' && !authStore.authenticated) {
    //     authStore.addAuthUserToStore().then(() => {
    //         if (!authStore.authenticated) {
    //             next ({ name: 'login' });
    //         } else {
    //             next();
    //         }
    //     })
    // } else {
    //     next();
    // }
    // if (to.meta.middleware === 'guest') {
    //     if (authStore.authenticated) {
    //         next({ name: 'teacher' })
    //     } else next()
    // } else if (to.meta.middleware === 'auth') {
    //     if (authStore.authenticated) {
    //         next()
    //     } else {
    //         next({ name: 'login' })
    //     }
    // }
});

export default router;

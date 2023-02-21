import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from '../stores/auth';
import guest from "../middleware/guest";
import auth from "../middleware/auth";
import teacher from "../middleware/teacher";
import middlewarePipeline from "./middlewarePipeline";

const routes = [
    {
        path: '/welcome',
        name: 'welcome',
        component: () => import('../components/Welcome.vue'),
        meta: {
            middleware: [guest],
            title: 'Welcome'
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
        path: '/reset-password',
        name: 'reset-password',
        component: () => import('../components/Auth/ResetPassword.vue'),
        meta: {
            middleware: [guest],
            title: 'Reset password'
        }
    },
    {
        path: '/',
        name: 'index',
        component: () => import('../components/Index.vue'),
        meta: {
            middleware: [auth],
            title: 'Main'
        },
        children: [
            {
                path: '/profile',
                name: 'profile',
                component: () => import('../components/Profile/Profile.vue'),
                meta: {
                    middleware: [auth],
                    title: 'Profile'
                }
            },
            {
                path: '/courses',
                name: 'courses',
                component: () => import('../components/Course/Index.vue'),
                meta: {
                    middleware: [auth],
                    title: 'Courses'
                },
            },
            {
                path: '/courses/:id',
                name: 'courses.show',
                component: () => import('../components/Course/Show.vue'),
                meta: {
                    middleware: [auth],
                    title: 'Show course'
                }
            },
            {
                path: '/courses/create',
                name: 'courses.create',
                component: () => import('../components/Course/Create.vue'),
                meta: {
                    middleware: [auth, teacher],
                    title: 'Creating course'
                }
            },
            {
                path: '/courses/:course_id/lessons/:lesson_id',
                name: 'lessons.show',
                component: () => import('../components/Course/Lesson/Show.vue'),
                meta: {
                    middleware: [auth],
                    title: 'Show lesson'
                }
            },
            {
                path: '/courses/:course_id/lessons/create',
                name: 'lessons.create',
                component: () => import('../components/Course/Lesson/Create.vue'),
                meta: {
                    middleware: [auth, teacher],
                    title: 'Create lesson'
                }
            },
            {
                path: '/chat/:id',
                name: 'chat',
                component: () => import('../components/Chat/Chat.vue'),
                meta: {
                    middleware: [auth],
                    title: 'Chat'
                }
            }
        ]
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})


router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
    const middleware = to.meta.middleware;
    const context = { to, from, next, authStore };
    document.title = to.meta.title;

    if (!middleware) {
        return next();
    }
    return middleware[0]({
        ...context,
        nextMiddleware: middlewarePipeline(context, middleware, 1),
    })
});

export default router;

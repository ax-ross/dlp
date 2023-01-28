import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from '../stores/auth'
import guest from "../middleware/guest";
import auth from "../middleware/auth";
import teacher from "../middleware/teacher";
import student from "../middleware/student";
import middlewarePipeline from "./middlewarePipeline";
import Welcome from "../components/Welcome.vue";
import Index from "../components/Index.vue";
import CourseIndex from "../components/Course/Index.vue";
import CourseShow from "../components/Course/Show.vue";
import CourseCreate from "../components/Course/Create.vue"
import Chat from "../components/Chat/Chat.vue";

const routes = [
    {
        path: '/welcome',
        name: 'welcome',
        component: Welcome,
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
        component: Index,
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
                component: CourseIndex,
                meta: {
                    middleware: [auth],
                    title: 'Courses'
                },
            },
            {
                path: '/courses/:id',
                name: 'courses.show',
                component: CourseShow,
                meta: {
                    middleware: [auth],
                    title: 'Show course'
                }
            },
            {
                path: '/courses/create',
                name: 'courses.create',
                component: CourseCreate,
                meta: {
                    middleware: [auth, teacher],
                    title: 'Creating course'
                }
            },
            {
                path: '/chat/:id',
                name: 'chat',
                component: Chat,
                meta: {
                    middleware: [auth],
                    title: 'Chat'
                }
            }
        ]
    },















        // {
        //     path: '/teacher',
        //     name: 'teacher',
        //     component: () => import('../components/Teacher/Index.vue'),
        //     meta: {
        //         middleware: [auth, teacher],
        //         title: 'Teacher'
        //     },
        //     children: [
        //         {
        //             path: '/teacher/courses',
        //             name: 'teacher.courses',
        //             component: () => import('../components/Teacher/Course/Index.vue'),
        //             meta: {
        //                 middleware: [auth, teacher],
        //                 title: 'Courses'
        //             },
        //         },
        //         {
        //             path: '/teacher/courses/create',
        //             name: 'teacher.courses.create',
        //             component: () => import('../components/Teacher/Course/Create.vue'),
        //             meta: {
        //                 middleware: [auth, teacher],
        //                 title: 'Создание курса'
        //             }
        //         },
        //         {
        //             path: '/teacher/courses/:id',
        //             name: 'teacher.courses.show',
        //             component: () => import('../components/Teacher/Course/Show.vue'),
        //             meta: {
        //                 middleware: [auth, teacher],
        //                 title: 'Просмотр курса'
        //             }
        //         },
        //         {
        //             path: 'teacher/courses/:id/chat',
        //             name: 'teacher.courses.chat',
        //             component: () => import('../components/Teacher/Course/Chat.vue'),
        //             meta: {
        //                 middleware: [auth, teacher],
        //                 title: 'Чат курса'
        //             }
        //         }
        //     ]
        // },
        // {
        //     path: '/student',
        //     name: 'student',
        //     component: () => import('../components/Student/Index.vue'),
        //     meta: {
        //         middleware: [auth, student],
        //         title: 'Student'
        //     },
        //     children: [
        //         {
        //             path: '/student/courses',
        //             name: 'student.courses',
        //             component: () => import('../components/Student/Course/Index.vue'),
        //             meta: {
        //                 middleware: [auth, student],
        //                 title: 'Courses'
        //             }
        //         }, {
        //             path: '/student/courses/:id',
        //             name: 'student.courses.show',
        //             component: () => import('../components/Student/Course/Show.vue'),
        //             meta: {
        //                 middleware: [auth, student],
        //                 title: 'Просмотр курса'
        //             }
        //         },
        //         {
        //             path: 'student/courses/:id/chat',
        //             name: 'student.courses.chat',
        //             component: () => import('../components/Student/Course/Chat.vue'),
        //             meta: {
        //                 middleware: [auth, student],
        //                 title: 'Чат курса'
        //             }
        //         }
        //     ]
        // },
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

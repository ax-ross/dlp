export default function student({ next, authStore }) {
    if (authStore.user.role === 'student') {
        next();
    } else {
        next({ name: 'teacher' })
    }
}

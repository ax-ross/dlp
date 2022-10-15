export default function teacher({ next, authStore }) {
    if (authStore.user.role === 'teacher') {
        next();
    } else {
        next({ name: 'student' })
    }
}

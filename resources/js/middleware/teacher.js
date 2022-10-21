export default function teacher({ next, authStore, nextMiddleware }) {
    if (authStore.user.role === 'teacher') {
        nextMiddleware();
    } else {
        next({ name: 'student' })
    }
}

export default function student({ next, authStore, nextMiddleware }) {
    if (authStore.user.role === 'student') {
        nextMiddleware();
    } else {
        next({ name: 'teacher' })
    }
}

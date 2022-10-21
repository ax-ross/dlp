export default function auth({ next, authStore, nextMiddleware }) {
    if (!authStore.authenticated) {
        authStore.addAuthUserToStore().then(() => {
            if (!authStore.authenticated) {
                next({ name: 'login' });
            } else {
                nextMiddleware();
            }
        })
    } else {
        nextMiddleware();
    }
}

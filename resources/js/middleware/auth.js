export default function auth({ to, next, authStore, nextMiddleware }) {
    if (!authStore.authenticated) {
        authStore.addAuthUserToStore().then(() => {
            if (!authStore.authenticated) {
                if (to.path === '/') {
                    next({ name: 'welcome' });
                } else {
                    next({ name: 'login' });
                }
            } else {
                nextMiddleware();
            }
        })
    } else {
        nextMiddleware();
    }
}

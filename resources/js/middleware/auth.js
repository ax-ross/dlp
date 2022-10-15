export default function auth({ to, next, authStore }) {
    if (!authStore.authenticated) {
        authStore.addAuthUserToStore().then(() => {
            if (!authStore.authenticated) {
                next({ name: 'login' });
            } else {
                next();
            }
        })
    } else {
        next();
    }
}

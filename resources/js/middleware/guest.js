export default function guest({ next, authStore, nextMiddleware }) {
    if (!authStore.authenticated) {
        authStore.addAuthUserToStore().then(() => {
           if (authStore.authenticated) {
               next({name: 'index'})
           } else {
               nextMiddleware();
           }
        });
    } else {
        nextMiddleware();
    }
}

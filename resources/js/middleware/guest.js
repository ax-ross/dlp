export default function guest({ next, authStore, nextMiddleware }) {
    if (!authStore.authenticated) {
        authStore.addAuthUserToStore().then(() => {
           if (authStore.authenticated) {
               if (authStore.user.role === 'teacher') {
                   next({ name: 'teacher' })
               } else {
                   next( { name: 'student' } )
               }
           } else {
               nextMiddleware()
           }
        });
    } else {
        nextMiddleware();
    }
}

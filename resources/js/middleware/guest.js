export default function guest({ next, authStore }) {
    if (!authStore.authenticated) {
        authStore.addAuthUserToStore().then(() => {
           if (authStore.authenticated) {
               if (authStore.user.role === 'teacher') {
                   next({ name: 'teacher' })
               } else {
                   next( { name: 'student' } )
               }
           } else {
               next()
           }
        });
    } else {
        next();
    }
}

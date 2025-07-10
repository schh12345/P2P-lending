export default defineNuxtPlugin(() => {
    const userStore = useUser()

    // Initialize store from localStorage on app start
    userStore.initializeFromStorage()
}, { priority: 10 }) // Higher priority means it runs first
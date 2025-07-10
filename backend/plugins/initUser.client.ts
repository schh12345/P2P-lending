

import { useUser } from '~/stores/useUser'
import axios from 'axios'

export default defineNuxtPlugin(() => {
    const userStore = useUser()

    // Initialize the user store from localStorage immediately on client
    userStore.initializeFromStorage()

    // If token exists, set it as Axios default Authorization header
    if (userStore.token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${userStore.token}`
    }

    // Watch for token changes to update Axios header dynamically
    watch(
        () => userStore.token,
        (newToken) => {
            if (newToken) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${newToken}`
            } else {
                delete axios.defaults.headers.common['Authorization']
            }
        },
        { immediate: true }
    )
})
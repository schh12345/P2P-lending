import axios from 'axios'
import { useUser } from '~/stores/useUser'

export default defineNuxtPlugin(async (nuxtApp) => {
    const config = useRuntimeConfig()
    axios.defaults.baseURL = config.public.apiBase

    if (process.client) {
        const userStore = useUser()

        // Initialize from storage
        userStore.initializeFromStorage()

        // If token exists, fetch profile to sync with backend
        if (userStore.token) {
            try {
                await userStore.fetchProfile()
            } catch (error) {
                userStore.logout()
                navigateTo('/admin/login')
            }
        }

        // Set token headers
        if (userStore.token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${userStore.token}`
        }

        watch(() => userStore.token, (newToken) => {
            if (newToken) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${newToken}`
            } else {
                delete axios.defaults.headers.common['Authorization']
            }
        }, { immediate: true })

        // 401 interceptor
        axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response?.status === 401) {
                    userStore.logout()
                    navigateTo('/admin/login')
                }
                return Promise.reject(error)
            }
        )
    }

    return {
        provide: {
            axios
        }
    }
})

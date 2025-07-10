import { defineNuxtRouteMiddleware, navigateTo } from '#app'
import { useUser } from '~/stores/useUser'

export default defineNuxtRouteMiddleware((to, from) => {
    const userStore = useUser()

    if (!userStore.isAuthenticated) {
        return navigateTo('/admin/login')
    }
})
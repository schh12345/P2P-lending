import {useAuth} from '@/composables/useAuth'
export default defineNuxtRouteMiddleware(async()=> {
    const token = useAuth()
    if (!token.value) {
        return navigateTo('/userUI/authentication/borrower/login')
    }

})
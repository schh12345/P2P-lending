import { useAuthLender } from "@/composables/useAuthLender";
export default defineNuxtRouteMiddleware( ()=> {
    const token=useAuthLender()
    if (!token.value) {
        return navigateTo('/userUI/authentication/lender/login')
    }
})
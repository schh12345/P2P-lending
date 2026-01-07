<template>
  <div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 space-y-6 text-center">
      <div class="flex justify-center">
        <svg class="w-20 h-20 text-yellow-400 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M12 20.5C6.753 20.5 2.5 16.247 2.5 11S6.753 1.5 12 1.5 21.5 5.753 21.5 11 17.247 20.5 12 20.5z"/>
        </svg>
      </div>
      <h2 class="text-2xl font-bold text-gray-800">Awaiting Approval</h2>
      <p class="text-gray-600">
        Your account is currently under review. Please wait while an admin approves your access.
      </p>
      <div class="mt-6">
        <NuxtLink to="/userUI/frontpage/" class="text-blue-500 hover:underline text-sm">Back to home page</NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup>
definePageMeta({
    layout:'default'

})

import { useRuntimeConfig, useRouter ,} from '#app'
import {useAuth} from '@/composables/useAuth'

const config = useRuntimeConfig()



onMounted(async()=> {

    try {
        const res = await $fetch(`${config.public.sanctum.baseUrl}/ApproveForBorrower`, {
            methos:'POST'
        })
        if (res && res.msg) {
            alert(res.msg)
          
        } else if (res && res.borrower) {
            alert ('your account has been approve')
        }
    } catch (error) {
      console.log(error)
        alert ('error')
    }



})





// This could later check auth status or poll an API for updates
</script>

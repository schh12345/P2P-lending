<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 p-4">
    <div class="w-full max-w-md">
      <!-- Background decorative elements -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
      </div>

      <!-- Main login card -->
      <div class="relative bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 p-8 transform transition-all duration-300 hover:shadow-3xl">
        <!-- Header -->
        <div class="text-center mb-8">
          <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
          </div>
          <h1 class="text-3xl font-bold text-white mb-2">Admin Portal</h1>
          <p class="text-gray-300">Welcome back, please sign in to continue</p>
        </div>

        <!-- Login form -->
        <form @submit.prevent="login" class="space-y-6">
          <!-- Email field -->
          <div class="relative">
            <label for="email" class="text-sm font-medium text-gray-200 mb-2 block">Email Address</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
              </div>
              <input
                  id="email"
                  v-model="email"
                  type="email"
                  placeholder="Enter your email"
                  required
                  :class="inputClasses"
                  class="pl-10"
              />
            </div>
          </div>

          <!-- Password field -->
          <div class="relative">
            <label for="password" class="text-sm font-medium text-gray-200 mb-2 block">Password</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
              </div>
              <input
                  id="password"
                  v-model="password"
                  :type="showPassword ? 'text' : 'password'"
                  placeholder="Enter your password"
                  required
                  :class="inputClasses"
                  class="pl-10 pr-10"
              />
              <button
                  type="button"
                  @click="showPassword = !showPassword"
                  class="absolute inset-y-0 right-0 pr-3 flex items-center"
              >
                <svg v-if="showPassword" class="h-5 w-5 text-gray-400 hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                </svg>
                <svg v-else class="h-5 w-5 text-gray-400 hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
              </button>
            </div>
          </div>

          <!-- Error message -->
          <transition name="error-fade">
            <div v-if="error" class="bg-red-500/10 border border-red-500/20 rounded-lg p-3 backdrop-blur-sm">
              <div class="flex items-center">
                <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-red-400 text-sm">{{ error }}</p>
              </div>
            </div>
          </transition>

          <!-- Submit button -->
          <button
              type="submit"
              :disabled="loading"
              :class="buttonClasses"
              class="group relative w-full"
          >
            <span v-if="loading" class="flex items-center justify-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Signing in...
            </span>
            <span v-else class="flex items-center justify-center">
              Sign In
              <svg class="ml-2 -mr-1 w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
              </svg>
            </span>
          </button>
        </form>

        <!-- Signup link -->
        <div class="mt-6 text-center">
          <p class="text-gray-400 text-sm mb-4">
            Don't have an account?
          </p>
          <NuxtLink
              to="/admin/signup"
              class="group relative inline-flex items-center justify-center px-6 py-2 bg-white/10 text-white font-medium rounded-lg border border-white/20 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/50 transform transition-all duration-200 hover:scale-105 active:scale-95"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Request Admin Access
          </NuxtLink>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
          <p class="text-gray-400 text-sm">
            Secure admin access • Protected by encryption
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useUser } from '@/stores/useUser'
import axios from 'axios'

axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

const email = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)
const showPassword = ref(false)

const router = useRouter()
const userStore = useUser()

const login = async () => {
  loading.value = true
  try {
    const response = await axios.post('/admin/login', { email: email.value, password: password.value })

    localStorage.setItem('auth_token', response.data.token)
    userStore.setToken(response.data.token)
    userStore.setUserProfile(response.data.admin)

    await router.push('/admin/home/dashboard')
  } catch (err) {
    console.error('Login failed:', err.response?.data?.message || err.message)
    error.value = 'Login failed. Please check your credentials.'
  } finally {
    loading.value = false
  }
}

const inputClasses = computed(() =>
    'w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-400 ' +
    'focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent ' +
    'backdrop-blur-sm transition-all duration-200 hover:bg-white/10 ' +
    'focus:bg-white/10'
)

const buttonClasses = computed(() =>
    'w-full px-4 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium rounded-lg ' +
    'hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-900 ' +
    'disabled:opacity-50 disabled:cursor-not-allowed transform transition-all duration-200 ' +
    'hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl'
)
</script>

<style scoped>
.error-fade-enter-active, .error-fade-leave-active {
  transition: all 0.3s ease;
}
.error-fade-enter-from, .error-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

.hover\:shadow-3xl:hover {
  box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
}

.backdrop-blur-xl {
  backdrop-filter: blur(20px);
}
</style>

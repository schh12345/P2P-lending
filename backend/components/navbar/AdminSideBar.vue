<script setup>
import { ref } from 'vue'
import {watchEffect} from 'vue'
import { useRoute, useRouter } from 'nuxt/app'
import {
    ChevronDown,
    Home,
    FileText,
    Grid3X3,
    Settings,
    BarChart3,
    Users,
    FileCheck,
    CreditCard,
    User,
    Monitor,
    Sliders,
    Search
} from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()

const open = ref({
    home: true,
    applications: false,
    pages: false,
    settings: false,
})

// Toggle collapsible sidebar sections
const toggle = (section) => {
    open.value[section] = !open.value[section]
}

// Check if the current route matches the path
const isActive = (path) => {
    return route.path === path
}

// Return dynamic classes based on active status
const getClass = (path) => {
    const baseClasses = 'w-full flex items-center space-x-3 p-2 rounded-lg text-sm transition-colors hover:bg-white/10'
    return isActive(path)
        ? `${baseClasses} text-blue-400 bg-white/10 font-semibold`
        : `${baseClasses} text-white/70 hover:text-white`
}

// Navigate and expand the correct section
const navigateTo = async (path) => {
    await router.push(path)

    if (path.startsWith('/admin/home')) {
        open.value.home = true
    } else if (path.startsWith('/admin/applications')) {
        open.value.applications = true
    } else if (path.startsWith('/admin/pages')) {
        open.value.pages = true
    } else if (path.startsWith('/admin/settings')) {
        open.value.settings = true
    }
}

watchEffect(() => {
    const path = route.path
    if (path.startsWith('/admin/home')) open.value.home = true
    else if (path.startsWith('/admin/applications')) open.value.applications = true
    else if (path.startsWith('/admin/pages')) open.value.pages = true
    else if (path.startsWith('/admin/settings')) open.value.settings = true
})
</script>

<template>
    <!-- Remove the outer div wrapper and full-screen classes -->
    <div class="h-full bg-white/10 backdrop-blur-xl border-r border-white/20 shadow-2xl bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
        <!-- Header -->
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <Grid3X3 class="w-5 h-5 text-white" />
                </div>
                <div class="flex-1">
                    <h2 class="text-white font-semibold text-lg">Loan Bridge</h2>
                    <p class="text-white/60 text-sm">Admin Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="p-4 space-y-2 overflow-y-auto h-[calc(100%-120px)]">
            <!-- Home -->
            <div class="space-y-1">
                <button @click="toggle('home')" class="w-full flex items-center justify-between p-3 rounded-xl text-white/90 hover:bg-white/10 transition">
                    <div class="flex items-center space-x-3">
                        <Home class="w-5 h-5 text-blue-400" />
                        <span>Home</span>
                    </div>
                    <ChevronDown class="w-4 h-4" :class="{ 'rotate-180': open.home }" />
                </button>
                <div v-if="open.home" class="ml-4 space-y-1">
                    <button @click="navigateTo('/admin/home/dashboard')" :class="getClass('/admin/home/dashboard')">
                        <BarChart3 class="w-4 h-4" />
                        <span>Dashboard</span>
                    </button>
                    <button @click="navigateTo('/admin/home/analytics')" :class="getClass('/admin/home/analytics')">
                        <BarChart3 class="w-4 h-4" />
                        <span>Analytics</span>
                    </button>
                </div>
            </div>

            <!-- Pages -->
            <div class="space-y-1">
                <button @click="toggle('pages')" class="w-full flex items-center justify-between p-3 rounded-xl text-white/90 hover:bg-white/10 transition">
                    <div class="flex items-center space-x-3">
                        <FileText class="w-5 h-5 text-green-400" />
                        <span>Pages</span>
                    </div>
                    <ChevronDown class="w-4 h-4" :class="{ 'rotate-180': open.pages }" />
                </button>
                <div v-if="open.pages" class="ml-4 space-y-1">
                    <button @click="navigateTo('/admin/pages/users/user-management')" :class="getClass('/admin/pages/users/new-user')">
                        <Users class="w-4 h-4" />
                        <span>User-Management</span>
                    </button>
                    <button @click="navigateTo('/admin/pages/users/report')" :class="getClass('/admin/pages/users/report')">
                        <FileCheck class="w-4 h-4" />
                        <span>Report</span>
                    </button>
                </div>
            </div>

          <!-- Applications -->
          <div class="space-y-1">
            <button @click="toggle('applications')" class="w-full flex items-center justify-between p-3 rounded-xl text-white/90 hover:bg-white/10 transition">
              <div class="flex items-center space-x-3">
                <Grid3X3 class="w-5 h-5 text-purple-400" />
                <span>Applications</span>
              </div>
              <ChevronDown class="w-4 h-4" :class="{ 'rotate-180': open.applications }" />
            </button>
            <div v-if="open.applications" class="ml-4 space-y-1">
              <button @click="navigateTo('/admin/applications/loan-management')" :class="getClass('/admin/applications/loan-request')">
                <CreditCard class="w-4 h-4" />
                <span>Loan Request</span>
              </button>
              <button @click="navigateTo('/admin/applications/loan-detail')" :class="getClass('/admin/applications/detail')">
                <CreditCard class="w-4 h-4" />
                <span>Loan Details</span>
              </button>
            </div>
          </div>

            <!-- Settings -->
            <div class="space-y-1">
                <button @click="toggle('settings')" class="w-full flex items-center justify-between p-3 rounded-xl text-white/90 hover:bg-white/10 transition">
                    <div class="flex items-center space-x-3">
                        <Settings class="w-5 h-5 text-orange-400" />
                        <span>Settings</span>
                    </div>
                    <ChevronDown class="w-4 h-4" :class="{ 'rotate-180': open.settings }" />
                </button>
                <div v-if="open.settings" class="ml-4 space-y-1">
                    <button @click="navigateTo('/admin/settings/account-settings')" :class="getClass('/admin/settings/account-settings')">
                        <User class="w-4 h-4" />
                        <span>Account Settings</span>
                    </button>
                    <button @click="navigateTo('/admin/settings/platform-settings')" :class="getClass('/admin/settings/platform-settings')">
                        <Monitor class="w-4 h-4" />
                        <span>Platform Settings</span>
                    </button>
                    <button @click="navigateTo('/admin/settings/loan-configuration')" :class="getClass('/admin/settings/loan-configuration')">
                        <Sliders class="w-4 h-4" />
                        <span>Loan Configuration</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

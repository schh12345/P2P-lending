<template>
  <!-- Admin Header -->
  <header class="bg-white/10 backdrop-blur-xl border-b border-white/20 shadow-2xl bg-gradient-to-r from-slate-900 via-purple-900 to-slate-900">
    <div class="flex justify-between items-center px-8 py-6">

      <!-- Left Section - Toggle & Title -->
      <div class="flex items-center gap-6">
        <button
            @click="onToggleSidebar"
            class="group p-2 rounded-xl bg-white/10 hover:bg-white/20 transition-all duration-200 border border-white/10"
        >
          <Menu class="w-5 h-5 text-white group-hover:scale-110 transition-transform duration-200" />
        </button>

        <div>
          <h1 class="text-2xl font-bold bg-gradient-to-r from-white to-white/80 bg-clip-text text-transparent">
            Admin Dashboard
          </h1>
          <p class="text-white/60 text-sm mt-1">Welcome back, manage your platform</p>
        </div>
      </div>

      <!-- Center Section - Search -->
      <div class="flex-1 max-w-2xl mx-8">
        <div class="relative group">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <Search class="h-5 w-5 text-white/40 group-focus-within:text-white/70 transition-colors duration-200" />
          </div>
          <input
              type="text"
              v-model="searchQuery"
              @input="handleSearch"
              placeholder="Search for anything here..."
              class="w-full pl-12 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-400/50 focus:border-blue-400/50 focus:bg-white/20 transition-all duration-200 backdrop-blur-sm"
          />
          <ul v-if="filteredPages.length && searchQuery" class="absolute z-50 mt-1 w-full bg-white text-black rounded-xl shadow-lg overflow-hidden">
            <li
                v-for="page in filteredPages"
                :key="page.path"
                @click="goToPage(page.path)"
                class="px-4 py-2 cursor-pointer hover:bg-gray-100 text-sm transition-colors"
            >
              {{ page.label }}
            </li>
          </ul>
          <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/10 to-purple-500/10 opacity-0 group-focus-within:opacity-100 transition-opacity duration-200 pointer-events-none"></div>
        </div>
      </div>

      <!-- Right Section - Profile -->
      <div class="flex items-center gap-4">
        <div class="relative">
          <button
              @click="toggleDropdown"
              class="flex items-center gap-3 p-2 rounded-xl bg-white/10 hover:bg-white/20 transition-all duration-200 border border-white/10 group"
          >
            <div class="relative">
              <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center overflow-hidden">
                <img
                    v-if="user.profilePictureUrl"
                    :src="user.profilePictureUrl"
                    alt="Profile"
                    class="w-full h-full object-cover"
                    @error="hideImage"
                />
                <User v-else class="w-5 h-5 text-white" />
              </div>
              <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white/20"></div>
            </div>

            <div class="text-left hidden md:block">
              <div class="text-sm font-semibold text-white">{{ user.fullName }}</div>
              <div class="text-xs text-white/60">{{ user.gmail }}</div>
            </div>

            <ChevronDown
                class="w-4 h-4 text-white/70 transition-transform duration-200"
                :class="{ 'rotate-180': dropdownOpen }"
            />
          </button>

          <!-- Dropdown Menu -->
          <div
              v-if="dropdownOpen"
              class="absolute right-0 mt-2 w-56 bg-white/95 backdrop-blur-xl rounded-xl border border-white/20 shadow-2xl z-50"
          >
            <div class="p-2">
              <div class="px-4 py-3 border-b border-gray-200/20">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center overflow-hidden">
                    <img
                        v-if="user.profilePictureUrl"
                        :src="user.profilePictureUrl"
                        alt="Profile"
                        class="w-full h-full object-cover"
                        @error="hideImage"
                    />
                    <User v-else class="w-5 h-5 text-white" />
                  </div>
                  <div>
                    <p class="font-semibold text-gray-800">{{ user.fullName }}</p>
                    <p class="text-sm text-gray-600">Administrator</p>
                  </div>
                </div>
              </div>

              <div class="py-2">
                <div class="border-t border-gray-200/20 my-2"></div>
                <button
                    @click="logout"
                    class="w-full flex items-center gap-3 px-4 py-2 text-left text-red-600 hover:bg-red-50/50 rounded-lg transition-colors"
                >
                  <LogOut class="w-4 h-4" />
                  <span class="text-sm">Logout</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </header>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { Menu, Search, User, LogOut, ChevronDown } from 'lucide-vue-next'
import { useRouter } from 'nuxt/app'
import { useUser } from '@/stores/useUser' // Import the user store

// Props and Emits
const props = defineProps({
  onToggleSidebar: Function,
  onSearch: Function
})
const emit = defineEmits(['update:searchQuery', 'logout'])

// Local States
const searchQuery = ref('')
const dropdownOpen = ref(false)

// Global User Store
const user = useUser()

// Nuxt Router
const router = useRouter()

// Search Handler
function handleSearch() {
  if (props.onSearch) {
    props.onSearch(searchQuery.value)
  }
  emit('update:searchQuery', searchQuery.value)
}

// Dropdown Handlers
function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
}

// Logout Handler
async function logout() {
  dropdownOpen.value = false
  user.logout() // Clear user data from store
  emit('logout')
  await router.push('/admin/login')
}

// Handle Image Errors
function hideImage(event: Event) {
  const target = event.target as HTMLImageElement
  target.style.display = 'none'
}

// Close dropdown on route change
watch(() => router.currentRoute.value.path, () => {
  dropdownOpen.value = false
})



const pages = [
  { label: 'Dashboard', path: '/admin/home/dashboard' },
  { label: 'Analytics', path: '/admin/home/analytics' },
  { label: 'User Management', path: '/admin/pages/users/user-management' },
  { label: 'User Report', path: '/admin/pages/users/report' },
  { label: 'Account Settings', path: '/admin/settings/account-settings' },
  { label: 'Platform Configuration', path: '/admin/settings/platform-configuration' },
  { label: 'Platform Settings', path: '/admin/settings/platform-settings' },
  { label: 'Loan Management', path: '/admin/applications/loan-management' },
  { label: 'Loan Details', path: '/admin/applications/loan-detail' }
]

const filteredPages = computed(() => {
  if (!searchQuery.value.trim()) return []
  return pages.filter(page =>
      page.label.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

function goToPage(path: string) {
  searchQuery.value = ''
  router.push(path)
}
</script>
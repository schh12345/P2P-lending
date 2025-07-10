<template>
    <div class="w-full h-screen overflow-hidden bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
        <div class="flex h-full">
            <!-- Sidebar -->
            <div
                :class="[
          'transition-all duration-300 h-full flex-shrink-0 overflow-hidden',
          isSidebarOpen ? 'w-80' : 'w-0'
        ]"
            >
                <div class="w-80 h-full">
                    <Sidebar />
                </div>
            </div>

            <!-- Main content wrapper -->
            <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
                <!-- Header -->
                <div class="flex-shrink-0">
                    <AdminHeader
                        :onToggleSidebar="toggleSidebar"
                        @search="handleSearch"
                        @logout="handleLogout"
                    />
                </div>

                <!-- Main content area -->
                <main class="flex-1 overflow-y-auto bg-gray-100">
                    <div class="p-6 w-full h-full">
                        <slot />
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from '~/components/navbar/AdminSideBar.vue'
import AdminHeader from '~/components/navbar/AdminHeader.vue'
import { useRouter } from 'nuxt/app'

const router = useRouter()
const isSidebarOpen = ref(true)
const searchQuery = ref('')

function toggleSidebar() {
    isSidebarOpen.value = !isSidebarOpen.value
}

function handleSearch(query) {
    searchQuery.value = query
    console.log('Search term:', query)
}

async function handleLogout() {
    console.log('Logging out...')
    await router.push('/login')
}
</script>

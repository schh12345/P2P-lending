<template>

<!-- Mobile menu button -->
              <div class="mt-[64px] z-25 insert-0 relative">
                  <div class="flex fixed w-full items-center justify-between p-0 bg-gray-100  border-b-1 border-gray-400">
                      <!-- <h1 class="text-xl font-semibold text-gray-900">Dashboard</h1> -->
                      <button
                          @click="toggleSidebar"
                          class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none"
                          aria-label="Toggle sidebar"
                      >
                          <svg v-if="!showSidebar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                          </svg>

                          <svg v-else class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                      </button>
                  </div>
              </div>
</template>

<script setup>
import { useSideNavLender } from '@/composables/useSideNavLender'

 const {toggleSidebar, showSidebar}=useSideNavLender()

</script>
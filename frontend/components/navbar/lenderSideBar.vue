<template>
        
         
                  

                  <!-- Mobile Sidebar Overlay -->
                  <!-- <div v-if="!showSidebar" class=" mt-[104px] fixed inset-0 z-20 bg-blue-100/30">                   -->
                      <!-- bg-[#100d50] -->
                      <!-- Mobile Sidebar -->
                      <!-- <div class="relative flex flex-col w-full md:w-sm h-full border-1 bg-white rounded-r-lg shadow-xl transform transition-transform duration-300 ease-in-out"> -->
                        <div class="h-full backdrop-blur-xl border-r border-white/20 shadow-2xl bg-[#100d50] transition-all duration-300 flex-shrink-0 overflow-hidden fixed rounded-r-lg">
                          <!-- Mobile Header -->
                          <!-- <div class="flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200">
                              <div class="flex items-center">
                                  <div class="flex-shrink-0">
                                      <div class="h-8 w-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                          <span class="text-white font-bold text-sm">D</span>
                                      </div>
                                  </div>
                                  <div class="ml-3">
                                      <h1 class="text-lg font-semibold text-gray-900">Dashboard</h1>
                                  </div>
                              </div>
                              <button
                                  @click="closeSidebar"
                                  class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                                  aria-label="Close sidebar"
                              >
                                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                  </svg>
                              </button>
                          </div> -->

                          <!-- Mobile Navigation -->
                          <nav class="flex-1 px-4 py-6 space-y-8 overflow-y-auto">
                              <!-- Main Navigation -->
                              <div>
                                  <h3 class="px-3 text-xs font-semibold text-gray-300 uppercase tracking-wider mb-3">
                                      Main
                                  </h3>
                                  <div class="space-y-1">
                                        <!--dashboard-->
                                      <NuxtLink
                                          to="/userUI/lender/dashboard"
                                         
                                          class="flex items-center px-3 py-3 text-base font-medium rounded-lg text-gray-100 hover:bg-blue-100 hover:text-gray-900 transition-colors"
                                      >
                                          <svg class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                          </svg>
                                          Dashboard
                                        </NuxtLink>
                                      <!--marketplace-->
                                      <NuxtLink
                                          to="/userUI/lender/marketplace"
                                        
                                          class="flex items-center px-3 py-3 text-base font-medium rounded-lg text-gray-100 hover:bg-blue-100 hover:text-gray-900 transition-colors"
                                      >
                                          <svg class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                          </svg>
                                          Marketplace
                                        </NuxtLink>
                                      
                                       <!--fund record-->
                                      <NuxtLink
                                          to="/userUI/lender/fundRecord"
                                         
                                          class="flex items-center px-3 py-3 text-base font-medium rounded-lg text-gray-100 hover:bg-blue-100 hover:text-gray-900 transition-colors"
                                      >
                                          <svg class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                          </svg>
                                          Fund Record
                                        </NuxtLink>

                                        <!--transaction record-->
                                        <NuxtLink
                                          to="/userUI/lender/transactionRecord"
                                         
                                          class="flex items-center px-3 py-3 text-base font-medium rounded-lg text-gray-100 hover:bg-blue-100 hover:text-gray-900 transition-colors"
                                      >
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>

                                          Transaction Record
                                        </NuxtLink>
                                  </div>
                              </div>

                              <!-- Management -->
                              <!-- <div>
                                  <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                      Management
                                  </h3>
                                  <div class="space-y-1">
                                      <a
                                          href="#users"
                                          @click="setActiveAndClose('users')"
                                          :class="getMobileNavClass('users')"
                                          class="flex items-center px-3 py-3 text-base font-medium rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors"
                                      >
                                          <svg class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197V9a3 3 0 00-3-3v4.422z" />
                                          </svg>
                                          Users
                                      </a>
                                      
                                      <a
                                          href="#projects"
                                          @click="setActiveAndClose('projects')"
                                          :class="getMobileNavClass('projects')"
                                          class="flex items-center px-3 py-3 text-base font-medium rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors"
                                      >
                                          <svg class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                          </svg>
                                          Projects
                                      </a>
                                      
                                      <a
                                          href="#teams"
                                          @click="setActiveAndClose('teams')"
                                          :class="getMobileNavClass('teams')"
                                          class="flex items-center px-3 py-3 text-base font-medium rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors"
                                      >
                                          <svg class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                          </svg>
                                          Teams
                                      </a>
                                  </div>
                              </div> -->

                              <!-- Settings -->
                              <!-- <div>
                                  <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                      Settings
                                  </h3>
                                  <div class="space-y-1">
                                      <a
                                          href="#settings"
                                          @click="setActiveAndClose('settings')"
                                          :class="getMobileNavClass('settings')"
                                          class="flex items-center px-3 py-3 text-base font-medium rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors"
                                      >
                                          <svg class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                          </svg>
                                          Settings
                                      </a>
                                  </div>
                              </div> -->
                          </nav>
                      </div>
                  <!-- </div> -->

                 
                  
       

</template>

<script setup>
  import home from '~/components/icons/home.vue'
  import shop from '~/components/icons/shop.vue'
  import { useSideNavLender } from '@/composables/useSideNavLender'
  const {showSidebar,
    activeSection, closeSidebar,
    setActiveAndClose,
    setActive,
    getNavClass,
    getMobileNavClass,} = useSideNavLender()
</script>
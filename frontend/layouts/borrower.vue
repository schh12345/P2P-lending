
<template>
    <div class="bg-gradient-to-br from-white via-gray-100 to-gray-200">
      <!-- bg-[#F7FAFF] -->
        <borrowerHead />
        
        <!-- <div class="md:grid md:grid-cols-12 md:pt-16 pt-10">
            <div class="md:col-span-3 lg:col-span-2">
                <sideNavLender />
            </div>
            <main class="md:col-span-9 lg:ml-20">
                <slot />
            </main>
        
        </div> -->
        <div class="flex flex-row h-screen mt-15">
          
            
            <borrowerSideBar :class='["overflow-y-auto transition-all duration-300",!showSidebar ? "md:w-60 w-full" :"w-0"]'/>
            
                
             <div :class='["border-1 overflow-y-auto transition-all duration-300  border-gray-300 h-full shadow-xl", !showSidebar ? "w-[20px] ml-60" : "w-0 ml-0"]'>
                
            </div>
            <div :class='["overflow-y-auto transition-all duration-300 w-full"]'>
                <main>
                <slot>
                  <p>{{ user.first_name }}</p>
                  <p>{{ user.last_name }}</p>
                </slot>
                </main>
                <foot />
            </div>
        </div>
    </div>

  
  
</template>


<script setup>

import borrowerHead from '~/components/navbar/borrowerHead.vue';
import borrowerSideBar from '~/components/navbar/borrowerSideBar.vue';
import foot from '~/components/footer/footer.vue';
import { useSideNavLender } from '~/composables/useSideNavLender';



// Reactive state
const {showSidebar}=useSideNavLender()





</script>
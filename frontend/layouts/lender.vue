
<template>
    <div class="bg-[#F7FAFF]">
        <lenderhead />
        
        <!-- <div class="md:grid md:grid-cols-12 md:pt-16 pt-10">
            <div class="md:col-span-3 lg:col-span-2">
                <sideNavLender />
            </div>
            <main class="md:col-span-9 lg:ml-20">
                <slot />
            </main>
        
        </div> -->
        <div class="flex flex-row h-screen mt-15">
          
            <div class="h-full">
            <lenderSideBar :class='["overflow-y-auto transition-all duration-300",!showSidebar ? "md:w-60 w-full" :"w-0"]'/>
            </div>
                
            <div :class='["border-1 overflow-y-auto transition-all duration-300  border-gray-300 h-full shadow-xl", !showSidebar ? "w-[20px] ml-60" : "w-0 ml-0"]'>
                
            </div>
            <div :class='["overflow-y-auto transition-all duration-300 w-full"]'>
                <main>
                <slot>

                </slot>
                </main>
                <foot />
            </div>
        </div>
    </div>

  
  
</template>


<script setup>

import lenderhead from '~/components/navbar/lenderHead.vue';
import lenderSideBar from '~/components/navbar/lenderSideBar.vue';
import foot from '~/components/footer/footer.vue';
import { useSideNavLender } from '@/composables/useSideNavLender';

const {showSidebar}= useSideNavLender()




</script>
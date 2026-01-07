<template>
  <footer class="bg-gray-900 text-white py-10 bg-[url('@/assets/image/footer.png')]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid lg:grid-cols-3 gap-x-8 sm:grid-cols-1">
        <!-- Brand Info -->
        <div class="lg:place-items-start sm:place-items-center sm:py-5">
            <div class="flex items-center justify-center gap-5">
                <img :src="logo" alt="logo" style="width:60px; height:60px;">
                <h2 class="text-2xl font-bold mb-2">P2P Market</h2>
            </div>
          <p class="text-sm text-gray-400">
            A secure and transparent peer-to-peer lending platform connecting borrowers and lenders directly.
          </p>
        </div>

        <!-- Quick Links -->
        <div class="place-items-center sm:py-5">
          <h3 class="text-xl font-semibold mb-3">Quick Links</h3>
          <ul class="space-y-2 text-gray-400">
            <li class="hover:text-white"><span class="pe-2">></span><NuxtLink to="/userUI/frontpage/">Home</NuxtLink></li>
            <li class="hover:text-white"><span class="pe-2">></span><NuxtLink to="/useruI/frontpage/lenderPage" >Lender</NuxtLink></li>
            <li class="hover:text-white"><span class="pe-2">></span><NuxtLink to="/userUI/frontpage/borrowerPage">Borrower</NuxtLink></li>
            <li class="hover:text-white"><span class="pe-2">></span><NuxtLink to="/useruI/frontpage/about">About Us</NuxtLink></li>
          </ul>
        </div>

        
        

        <!-- Follow Us -->
        <div class="lg:place-items-start lg:ps-20 px-0 sm:place-items-center place-items-center sm:py-5">
          <h3 class="text-xl font-semibold mb-3">Connect</h3>
            <div class="flex iters-center justify-center gap-x-5 mb-5">
              <location />
              <p class="text-sm text-gray-400 hover:text-white">315 Street, Sankat Boeung Kok1, Khan Toul Kork, Phnom Penh</p>
            </div>

            <div class="flex iters-center justify-center gap-x-5 mb-5">
                <mail />
                <p class="text-sm text-gray-400 hover:text-white">loanbridge7777@gmail.com</p>
            </div>

            <div class="flex iters-center justify-center gap-x-5 mb-5">
                <tell />
                <p class="text-sm text-gray-400 hover:text-white">099 234 168</p>
            </div>

            <div class="flex iters-center justify-center gap-x-5">
              <facebook />
              <messenger />
              <twitter />
              <linkedin />
            </div>
        </div>
      </div>

      <div class="border-t border-gray-700 my-2 text-sm text-center text-gray-400">
      
      </div>
      <div class="lg:flex items-center justify-between sm:place-items-center text-gray-400">
          <div class="sm:my-5">
          © {{ new Date().getFullYear() }} LoanBridge. All rights reserved.
          </div>
          <div class="flex justify-center items-center gap-x-5">
            <NuxtLink to="/userUI/frontpage/policy" class="hover:text-gray-300">Privacy Policy</NuxtLink>
            
          </div>
        </div>
    </div>
  </footer>
</template>

<script setup>
import logo from '~/assets/image/logo.png';
import location from '~/components/icons/location.vue';
import mail from '~/components/icons/mail.vue';
import tell from '~/components/icons/telephone.vue';
import facebook from '~/components/icons/facebook.vue';
import messenger from '~/components/icons/messenger.vue';
import twitter from '~/components/icons/twitter.vue';
import linkedin from '~/components/icons/linkedin.vue';

  name: "AppFooter"

</script>
<script setup>
  import logo from '~/assets/image/logo.png'
  import { ref, onMounted, onBeforeUnmount } from 'vue'

  const signUpOpen = ref(false)
  const loginOpen = ref(false)

  const signUpDropdownRef = ref(null)
  const loginDropdownRef = ref(null)

  function signUptoggleDropdown() {
    signUpOpen.value = !signUpOpen.value
    if (signUpOpen.value) loginOpen.value = false
  }

  function logintoggleDropdown() {
    loginOpen.value = !loginOpen.value
    if (loginOpen.value) signUpOpen.value = false
  }

  function handleClickOutside(event) {
    const isClickInsideSignUp = signUpDropdownRef.value?.contains(event.target)
    const isClickInsideLogin = loginDropdownRef.value?.contains(event.target)

    if (!isClickInsideSignUp) {
      signUpOpen.value = false
    }
    if (!isClickInsideLogin) {
      loginOpen.value = false
    }
  }

  onMounted(() => {
    document.addEventListener('click', handleClickOutside)
  })

  onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside)
  })

  const isOpen=ref(false);
</script>

<template>
  <header class="bg-white shadow-md">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-20 ">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        
        <img :src="logo" alt="logo" style="width:60px; height:60px;">
        

        <!-- Desktop Nav Links -->
        <nav class="hidden md:flex space-x-20">
          <NuxtLink to="/userUI/frontpage/" class="text-gray-700 hover:text-blue-600">Home</NuxtLink>
          <NuxtLink to="/userUI/frontpage/lenderPage" class="text-gray-700 hover:text-blue-600">Lender</NuxtLink>
          <NuxtLink to="/userUI/frontpage/borrowerPage" class="text-gray-700 hover:text-blue-600">Borrower</NuxtLink>
          <NuxtLink to="/userUI/frontpage/about" class="text-gray-700 hover:text-blue-600">About Us</NuxtLink>
        </nav>

         <!--sign up and login dropdown-->
        <div class="flex space-x-3">
          <!--sign up-->
          <div class="relative inline-block text-left" ref="signUpDropdownRef">
            <button
              @click="signUptoggleDropdown"
              class="inline-flex justify-center w-full px-4 py-[6px] border-2 border-white rounded-full bg-[#0866FF] text-white hover:bg-blue-500">

              <a href="#">Sign Up</a>
              <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path
                  fill-rule="evenodd"
                  d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>

            <div
              v-if="signUpOpen"
              class="absolute right-0 mt-2 w-[120px] bg-white border rounded-lg shadow-lg z-50"
            >
              <NuxtLink to="/userUI/authentication/lender/signUp" class="block px-4 py-2 text-sm rounded-lg text-gray-700 hover:bg-gray-200">Lender</NuxtLink>
              <NuxtLink to="/userUI/authentication/borrower/signUp" class="block px-4 py-2 text-sm round-lg text-gray-700 hover:bg-gray-200">Borrower</NuxtLink>
            </div>
          </div>
          <!--login dropdown-->
          <div class="relative inline-block text-left" ref="loginDropdownRef">
            <button
              @click="logintoggleDropdown"
              class="text-black inline-flex justify-center w-full px-4 py-[6px] rounded-full border border-blue-600 hover:bg-gray-100">

              <a href="#" >Log in</a>
              <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path
                  fill-rule="evenodd"
                  d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>

            <div
              v-if="loginOpen"
              class="absolute left-5 mt-2 w-[120px] place-items-start bg-white border rounded-lg shadow-lg z-50"
            >
              <NuxtLink to="/userUI/authentication/lender/login" class="block px-4 py-2 w-[120px] text-sm rounded-lg text-gray-700 hover:bg-gray-200">Lender</NuxtLink>
              <NuxtLink to="/userUI/authentication/borrower/login" class="block px-4 w-[120px] py-2 text-sm rounded-lg text-gray-700 hover:bg-gray-200">Borrower</NuxtLink>
            </div>
          </div>
        </div>

          <!-- Mobile Menu Button -->
          <button
            @click="isOpen = !isOpen"
            class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-100"
          >
            <svg
              v-if="!isOpen"
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg
              v-else
              class="w-6 h-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
    </div>

    <!-- Mobile Nav Links -->
    <div v-if="isOpen" class="md:hidden px-4 pb-4 space-y-2">
      <NuxtLink to="/userUI/frontpage/" class="block text-gray-700 hover:text-blue-600">Home</NuxtLink>
      <NuxtLink to="/userUI/frontpage/lenderPage" class="block text-gray-700 hover:text-blue-600">Lender</NuxtLink>
      <NuxtLink to="/userUI/frontpage/borrowerPage" class="block text-gray-700 hover:text-blue-600">Borrower</NuxtLink>
      <NuxtLink to="/userUI/frontpage/about" class="block text-gray-700 hover:text-blue-600">About Us</NuxtLink>
      
    </div>
  </header>

  <!--Hero-->
  
 
</template>


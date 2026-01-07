<template>
  <div class="min-h-screen bg-white">
    <!-- Header Section -->
    <div class="text-center py-16 px-4">
      <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-2 max-w-3xl mx-auto">
        Big banks say no. Our community says, '<span class="text-blue-600">Let's build it together</span>'
      </h1>
      <NuxtLink to="/userUI/authentication/borrower/signUp" class="bg-gray-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors mt-10">
        Start Now
      </NuxtLink>
    </div>

    <!-- Borrow Section -->
    <div class="bg-gray-50 py-16 px-4">
      <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <!-- Left Content -->
          <div>
            <h2 class="text-3xl font-bold text-gray-800 mb-6">
              Borrow based on your available
            </h2>
            <p class="text-gray-600 leading-relaxed">
              Create a loan request with reflecting basic personal, and location to represent to all lenders
            </p>
          </div>

          <!-- Right Content - Loan Application Preview -->
          <div class="relative">
            <!-- Background cards for depth -->
            <div class="absolute top-2 left-2 w-full h-full bg-blue-100 rounded-lg opacity-30"></div>
            <div class="absolute top-1 left-1 w-full h-full bg-blue-100 rounded-lg opacity-50"></div>
            
            <!-- Main card -->
            <div class="relative bg-white rounded-lg shadow-lg p-6 border-2 border-blue-200">
              <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                  <span class="text-white font-bold text-sm">SJ</span>
                </div>
                <div>
                  <h3 class="font-semibold text-gray-800">Sarah Johnson</h3>
                </div>
              </div>
              
              <div class="mb-4">
                <p class="text-3xl font-bold text-gray-800 mb-1">$2,500</p>
                <p class="text-sm text-gray-500">Requested Amount</p>
                <p class="text-sm text-gray-600 mt-2">$2,500</p>
              </div>
              
              <div class="flex space-x-2">
                <button class="flex-1 bg-gray-200 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium">
                  Decline
                </button>
                <button class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                  Fund Now
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Application Section -->
    <div class="py-16 px-4">
      <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <!-- Left Content - Features -->
          <img :src="banner" class="w-2/3 h-full">

          <!-- Right Content -->
          <div>
            <h2 class="text-3xl font-bold text-gray-800 mb-6">
              Apply in minutes and get funded in days — not weeks.
            </h2>
            <p class="text-gray-600 leading-relaxed mb-8">
              Fast approval process with community lenders, and quick fund disbursement that meet holds.
            </p>
            <button class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
              Get Started
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- How It Works Section -->
    <div class="bg-gray-50 py-16 px-4">
      <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-16">How It Work</h2>
        
        <div class="grid md:grid-cols-3 gap-8">
          <!-- Step 1 -->
          <div class="text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <span class="text-2xl font-bold text-blue-600">1</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Create Account</h3>
            <p class="text-gray-600">
              Add your information and choose borrower role
            </p>
          </div>

          <!-- Step 2 -->
          <div class="text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <span class="text-2xl font-bold text-blue-600">2</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Create request</h3>
            <p class="text-gray-600">
              Add loan information and post to the community
            </p>
          </div>

          <!-- Step 3 -->
          <div class="text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <span class="text-2xl font-bold text-blue-600">3</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Wait for Lenders to Fund</h3>
            <p class="text-gray-600">
              Our community of lenders will review and fund your loan request
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import banner from '~/assets/image/Screenshot 2025-07-10 235125.png'
definePageMeta({
        layout: 'default'
    })
// Page metadata
useHead({
  title: 'P2P Lending - Community Funding for Everyone',
  meta: [
    { name: 'description', content: 'When big banks say no, our community says yes. Get funded in days with peer-to-peer lending.' }
  ]
})
</script>

<style scoped>
/* Custom styles if needed */
</style>
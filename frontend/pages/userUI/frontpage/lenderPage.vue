<template>
  <div class="min-h-screen bg-white">
    <!-- Header Section -->
    <div class="text-center py-16 px-4">
      <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-2">
        Earn The Money From Your<br>Money
      </h1>
      <p class="text-xl text-blue-600 font-semibold mb-8">
        With Real People, Real Returns
      </p>
      <NuxtLink to="/userUI/authentication/lender/signUp" class="bg-gray-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
        Start Now
      </NuxtLink>
    </div>

    <!-- Browse and Fund Section -->
    <div class="bg-gray-50 py-16 px-4">
      <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <!-- Left Content -->
          <div>
            <h2 class="text-3xl font-bold text-gray-800 mb-6">
              Browse The Requests and Freely<br>Choose Who To Fund
            </h2>
            <p class="text-gray-600 leading-relaxed">
              Discover a bespoke lending experience where you stay in control. Our platform lets you explore loan opportunities and choose the right borrowers to fund according to your risk preference and return expectations.
            </p>
          </div>

          <!-- Right Content - Loan Card -->
          <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                <div class="w-8 h-8 bg-blue-600 rounded-full"></div>
              </div>
              <div>
                <h3 class="font-semibold text-gray-800">John Doe</h3>
                <p class="text-sm text-gray-500">Loan purpose: starting a business</p>
              </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
              <div class="text-center">
                <p class="text-2xl font-bold text-gray-800">$5,000</p>
                <p class="text-sm text-gray-500">Amount</p>
              </div>
              <div class="text-center">
                <p class="text-2xl font-bold text-blue-600">5.3%</p>
                <p class="text-sm text-gray-500">Rate</p>
              </div>
              <div class="text-center">
                <p class="text-2xl font-bold text-gray-800">1 months</p>
                <p class="text-sm text-gray-500">Term</p>
              </div>
            </div>
            
            <div class="mb-4">
              <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Funding progress</span>
                <span>68%</span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full w-2/3"></div>
              </div>
            </div>
            
            <button class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
              Fund Now
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Loan History Section -->
    <div class="py-16 px-4">
      <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <!-- Left Content - Loan History -->
          <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Loan History</h3>
            
            <div class="space-y-4">
              <div class="flex justify-between items-center py-3 border-b">
                <div>
                  <p class="font-semibold text-gray-800">Personal Loan</p>
                  <p class="text-sm text-gray-500">Lent to John Doe on Feb 15, 2024</p>
                </div>
                <div class="text-right">
                  <p class="font-semibold text-green-600">Returned</p>
                  <p class="text-sm text-gray-500">$2,500</p>
                </div>
              </div>
              
              <div class="flex justify-between items-center py-3 border-b">
                <div>
                  <p class="font-semibold text-gray-800">Personal Loan</p>
                  <p class="text-sm text-gray-500">Lent to Jane Smith on Jan 10, 2024</p>
                </div>
                <div class="text-right">
                  <p class="font-semibold text-orange-600">Pending</p>
                  <p class="text-sm text-gray-500">$1,200</p>
                </div>
              </div>
              
              <div class="flex justify-between items-center py-3">
                <div>
                  <p class="font-semibold text-gray-800">Personal Loan</p>
                  <p class="text-sm text-gray-500">Lent to Mike Johnson on Dec 22, 2023</p>
                </div>
                <div class="text-right">
                  <p class="font-semibold text-green-600">Returned</p>
                  <p class="text-sm text-gray-500">$3,800</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Content -->
          <div>
            <h2 class="text-3xl font-bold text-gray-800 mb-6">
              Allow You See Borrower History
            </h2>
            <p class="text-gray-600 leading-relaxed">
              Discover a transparent lending experience where you stay in control. Our platform lets you explore loan opportunities and choose the right borrowers to fund according to your risk preference and return expectations.
            </p>
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
              Sign up and choose lender role
            </p>
          </div>

          <!-- Step 2 -->
          <div class="text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <span class="text-2xl font-bold text-blue-600">2</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Explore the marketplace</h3>
            <p class="text-gray-600">
              Browse loan requests and choose who you want to fund
            </p>
          </div>

          <!-- Step 3 -->
          <div class="text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <span class="text-2xl font-bold text-blue-600">3</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Approve the requested loan</h3>
            <p class="text-gray-600">
              Your earning is on autopilot. Conveniently get loan repayment to your money
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
 definePageMeta({
        layout: 'default'
    })
// Page metadata
useHead({
  title: 'P2P Lending - Earn Money From Your Money',
  meta: [
    { name: 'description', content: 'Discover peer-to-peer lending with real people and real returns. Browse loan requests and choose who to fund.' }
  ]
})
</script>

<style scoped>
/* Custom styles if needed */
</style>
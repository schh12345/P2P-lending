<template>
  <div class="min-h-screen  flex items-center justify-center p-4">
    <div class="max-w-md w-full">
      <!-- Main Card -->
      <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
        <!-- Status Icon -->
        <div class="flex justify-center mb-6">
          <div class="relative">
            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center">
              <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <!-- Animated pulse ring -->
            <div class="absolute inset-0 w-20 h-20 rounded-full border-4 border-yellow-200 animate-ping"></div>
          </div>
        </div>

        <!-- Heading -->
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
          Account Under Review
        </h1>

        <!-- Description -->
        <p class="text-gray-600 mb-6 leading-relaxed">
          Thank you for signing up! Your account is currently being reviewed by our admin team. 
          We'll notify you once your account has been approved and you can start using our lending platform.
        </p>

        <!-- Status Badge -->
        <div class="inline-flex items-center px-4 py-2 bg-yellow-50 border border-yellow-200 rounded-full mb-6">
          <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></div>
          <span class="text-sm font-medium text-yellow-800">Pending Approval</span>
        </div>

        <!-- What's Next Section -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
          <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            What happens next?
          </h3>
          <ul class="space-y-2 text-sm text-gray-600">
            <li class="flex items-start">
              <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
              Our team will review your application within 1-2 business days
            </li>
            <li class="flex items-start">
              <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
              You'll receive an email notification once approved
            </li>
            <li class="flex items-start">
              <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
              Access to all lending and borrowing features will be unlocked
            </li>
          </ul>
        </div>

        <!-- Actions -->
        <div class="space-y-3">
          <button 
            @click="refreshStatus" 
            :disabled="isRefreshing"
            class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center"
          >
            <svg v-if="isRefreshing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ isRefreshing ? 'Checking...' : 'Check Status' }}
          </button>
          
          <button 
            @click="goToSupport"
            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-4 rounded-lg transition-colors duration-200"
          >
            Contact Support
          </button>
        </div>

        <!-- Footer Info -->
        <div class="mt-6 pt-4 border-t border-gray-100">
          <p class="text-xs text-gray-500">
            Need help? Email us at <a href="mailto:support@lendingplatform.com" class="text-blue-600 hover:underline">support@lendingplatform.com</a>
          </p>
        </div>
      </div>

      <!-- Additional Info Card -->
      <div class="mt-6 bg-white rounded-lg shadow-md p-4">
        <div class="flex items-center text-sm text-gray-600">
          <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span>Account created successfully on {{ formattedDate }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

// Page meta
definePageMeta({
    layout:'default'
})

// Reactive data
const isRefreshing = ref(false)
const accountCreatedDate = ref(new Date())

// Computed properties
const formattedDate = computed(() => {
  return accountCreatedDate.value.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
})

// Methods
const refreshStatus = async () => {
  isRefreshing.value = true
  
  // Simulate API call
  await new Promise(resolve => setTimeout(resolve, 1500))
  
  // Here you would typically make an API call to check approval status
  // For now, we'll just show the same pending state
  isRefreshing.value = false
  
  // You could add a toast notification here
  console.log('Status checked - still pending')
}

const goToSupport = () => {
  // Navigate to support page or open support widget
  // navigateTo('/support')
  console.log('Navigate to support')
}

// Lifecycle
onMounted(() => {
  // You might want to poll for status updates periodically
  // setInterval(checkStatusSilently, 30000) // Check every 30 seconds
})
</script>

<style scoped>
/* Custom animations */
@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: .5;
  }
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Responsive adjustments */
@media (max-width: 640px) {
  .rounded-2xl {
    border-radius: 1rem;
  }
}</style>
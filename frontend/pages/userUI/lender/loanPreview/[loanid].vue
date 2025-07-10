<template>
  
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div v-if="loading">loading loan information</div>
      <div v-else>
        <div v-if="loans" class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Left Sidebar -->
          <aside class="space-y-6">
            <!-- User Profile -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow p-6">
              <h4 class="text-xl font-semibold text-gray-800 mb-4">User Profile</h4>
              <div class="flex items-center space-x-3">
                <NuxtLink
                  to="#"
                  class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-semibold"
                >
                  {{ loans.borrower?.first_name.charAt(0).toUpperCase() }}{{ loans.borrower?.last_name.charAt(0).toUpperCase() }}
                            
                </NuxtLink>
                <span class="text-lg font-medium text-gray-900">{{ loans.borrower?.first_name }} {{ loans.borrower?.last_name }}</span>
              </div>

              <div class="mt-6 space-y-3 text-sm">
                <div class="flex justify-between text-gray-700">
                  <span>Credit Score</span>
                  <span class="text-green-600 font-semibold">{{ loans.borrower?.credit_score }}</span>
                </div>
                <div class="flex justify-between text-gray-700">
                  <span>Monthly Income</span>
                  <span>{{ loans.borrower?.income }}</span>
                </div>
                <div class="flex justify-between text-gray-700">
                  <span>{{ loans.borrower?.employment_status }}</span>
                  <span>Full Time</span>
                </div>
              </div>
            </div>

            <!-- Loan History -->
            <div class="bg-white rounded-2xl shadow p-6">
              <h5 class="text-lg font-semibold text-gray-800 mb-4">Loan History</h5>
              <div class="bg-gray-50 rounded-lg p-4 space-y-1 text-sm text-gray-700">
                <p><strong>Purpose:</strong> {{ loans.request_reason }}</p>
                <p><strong>Amount:</strong> {{ loans.request_amount }}</p>
                <p><strong>Interest Rate:</strong> {{ loans.interest_rate }}</p>
                <p><strong>Term:</strong> {{ loans.request_duration }}</p>
              </div>
            </div>
          </aside>

          <!-- Right Content -->
          <section class="md:col-span-2 space-y-8">
            <!-- Loan Details -->
            <div class="bg-white rounded-2xl shadow p-6">
              <h3 class="text-2xl font-bold text-gray-800 mb-6">Loan Details</h3>

              <div class="space-y-4 mb-5">
                <div>
                  <p class="text-gray-600 text-sm">Requested Amount</p>
                  <p class="text-3xl font-extrabold text-gray-900">{{ loans.request_amount }}</p>
                </div>

                <div class="space-y-2">
                  <div class="flex justify-between text-gray-700 text-sm">
                    <span>Interest rate</span>
                    <span>%{{ loans.interest_rate }}</span>
                  </div>
                  <div class="flex justify-between text-gray-700 text-sm">
                    <span>term</span>
                    <span>{{ loans.request_duration }}days</span>
                  </div>
                  <div class="flex justify-between text-gray-700 text-sm">
                    <span>Loan reason</span>
                    <span>{{ loans.request_reason }}</span>
                  </div>
                </div>
              </div>
              <!--total section-->
              <div class="border-t-1 border-gray-300">
                <div class="mt-5 flex justify-between text-gray-700 text-sm">
                  <span>Total Amount Pay Back</span>
                  <div class="text-lg">
                  {{ loans.total }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Submitted Documents -->
            <div class="bg-white rounded-2xl shadow p-6">
              <h3 class="text-2xl font-bold text-gray-800 mb-6">Submitted Document</h3>
              <div class="p-3 space-y-4">
                
                  <!-- <div class="bg-gray-200 p-4 rounded-lg">
                      <div class="bg-white rounded-xl p-4 flex justify-between items-center transition">
                          <div>
                            <p class="text-base font-medium text-gray-800">ID Verification</p>
                            <img :src="`http://localhost:8001${loans.borrower?.identity_path}`" class="w-full h-full" alternative="identity">
                          </div>
                  
                  </div>
                      
                     
                    
                  </div> -->
                
                <!--employment info-->
                <p class="text-base font-medium text-gray-800">Employment Document</p>
                <div class="bg-gray-200 p-4 rounded-lg">
                  
                      <div class="bg-white rounded-xl p-4 flex justify-between items-center transition">
                          <div>
                            
                            <img :src="`http://localhost:8001${loans.borrower?.employment_path}`" class="w-full h-1/6" alternative="identity">
                          </div>
                      </div>
                      
                    
                    
                  </div>
                <!-- You can add more documents here -->
              </div>
            </div>

            <!-- decision -->
            <div class="bg-white rounded-2xl shadow p-6">
              <h3 class="text-2xl font-bold text-gray-800 mb-6">Decision</h3>
              <div class="flex justify-between items-center mb-5 gap-x-2">
                <NuxtLink
                  :to="`/userUI/lender/approveLoan/${loans.id}`"
                  class="px-6 py-3 md:px-15 md:py-3 lg:px-30 lg:py-3 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg transition-colors duration-200 text-center block w-full sm:w-auto"
                >
                  Approve
                </NuxtLink>


                <NuxtLink
                  to="/userUI/lender/marketplace"
                  class="px-6 py-3 md:px-15 md:py-3 lg:px-30 lg:py-3 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg transition-colors duration-200 text-center block w-full sm:w-auto"
                >
                  Reject
                </NuxtLink>
                    
              </div>
              <div class="">
                <p class="text-gray-600 text-md font-semibold mb-3">Decision note</p>
                <div class="p10">
                  <textarea name="decision_note" id="" placeholder="Add note about your decision" class="bg-gray-50 w-full h-auto p-5 rounded-lg text-gray-900 text-md font-normal">

                  </textarea>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  
</template>

<script setup>

import { useAuth } from '~/composables/useAuth'
import { useRuntimeConfig, useRoute} from '#app'
import {ref, onMounted,computed} from 'vue'



definePageMeta({
  layout: 'lender',
  middleware: 'authlender'

})
const route=useRoute()
const token=useAuth()
const config=useRuntimeConfig()

const loans=ref()
const loading=ref(true)
const fullUrl = (path) => `http://localhost:8000${path}`

onMounted(async()=> {
  try{
    const res = await $fetch(`${config.public.sanctum.baseUrl}/getLoan/${route.params.loanid}`, {
      headers: {
        Authorization: `Bearer ${token.value}`,
      },    

    })

    if (res) {
      loans.value=res.loan
    }

  } catch(error) {
    console.error('Failed to fetch loans:', error)
  } finally {
    loading.value=false
  }
})

const identity_path=fullUrl(loans.identity_path)
const emp_path=fullUrl(loans.employment_path)








</script>

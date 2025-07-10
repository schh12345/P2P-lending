<template>


  <div class="p-4 md:p-8">
    

      <div class="mx-auto w-full md:flex md:justify-between gap-x-6">
        <!-- Total Balance Card -->
        <div class="border-1 border-gray-300 shadow-md bg-gradient-to-br from-blue-900 to-teal-700 w-full rounded-2xl p-6 flex flex-col justify-between space-y-5">
          <div class="flex justify-between border-b border-gray-200">
            <div>
              <h2 class="text-md font-normal text-gray-100">Available balance</h2>
              <p v-if="amount" class="text-3xl font-bold text-gray-100 mt-2">${{ amount.balance }}</p>
            </div>
            <div class="mt-5 mb-10 rounded-xl w-10 h-10 bg-yellow-500 px-2 py-2">
              <wallet />
            </div>
          </div>
          <div class="flex justify-start gap-x-20">
            <div>
              <h2 class="text-sm font-normal text-gray-100">Fund Active</h2>
              <p class="text-xl font-bold text-yellow-400 mt-2">10</p>
            </div>
            <div>
              <h2 class="text-sm font-normal text-gray-100">Return Amount</h2>
              <p class="text-xl font-bold text-yellow-400 mt-2">$9,246.57</p>
            </div>
          </div>
        </div>

        <!-- Transaction History -->
        <!-- <div class="border-1 border-gray-300 shadow-md bg-white rounded-2xl p-4 sm:p-6 w-full mt-6 md:mt-0">
          <h3 class="text-lg font-semibold text-gray-700 mb-4">Recent Transactions</h3>
          
          <div 
            v-for="transaction in transactions" 
            :key="transaction.id" 
            class="p-4 hover:bg-gray-50 transition-all border-b border-gray-100 last:border-b-0"
          >
            <div class="flex flex-wrap items-start justify-between gap-4">
              
             
              <div class="flex items-start gap-4 w-full sm:w-auto flex-1">
               
                <div 
                  :class="[
                    'p-3 rounded-full shrink-0',
                    transaction.type === 'received' 
                      ? 'bg-green-100 text-green-600' 
                      : 'bg-red-100 text-red-600'
                  ]"
                >
                  <span class="w-5 h-5 block" v-html="transaction.type === 'received' ? getIcon('arrowDownLeft') : getIcon('arrowUpRight')"></span>
                </div>

                
                <div class="flex flex-col gap-1">
                  <h4 class="font-semibold text-gray-900">
                    {{ transaction.description }}
                  </h4>
                  <div class="flex flex-wrap gap-x-2 gap-y-1 text-sm text-gray-600 items-center">
                    <span>{{ transaction.date }} • {{ transaction.time }}</span>
                    <span>•</span>
                    <span>{{ transaction.type === 'received' ? transaction.from : transaction.to }}</span>
                    <span 
                      :class="[
                        'px-2 py-0.5 rounded-full text-xs',
                        transaction.status === 'completed' 
                          ? 'bg-green-100 text-green-800' 
                          : 'bg-yellow-100 text-yellow-800'
                      ]"
                    >
                      {{ transaction.status }}
                    </span>
                  </div>
                </div>
              </div>

              
              <div class="text-right w-full sm:w-auto">
                <p 
                  :class="[
                    'text-lg font-semibold',
                    transaction.type === 'received' ? 'text-green-600' : 'text-red-600'
                  ]"
                >
                  {{ transaction.type === 'received' ? '+' : '-' }}${{ formatAmount(transaction.amount) }}
                </p>
                <p class="text-sm text-gray-500">{{ transaction.category }}</p>
              </div>
            </div>
          </div>
        </div> -->

        <!--amount return back-->
         <!-- <div class="border-1 border-gray-300 shadow-md bg-white w-full rounded-2xl p-6 flex flex-col justify-between">
          <div class="flex justify-between">
            <div>
              <p class="text-lg font-normal text-gray-700">Amount Return</p>
              <p class="text-3xl font-bold text-gray-900 mt-2">$9,246.57</p>
            </div>
            <div class="mt-5 rounded-xl w-10 h-10 bg-green-200 px-2 py-2">
              <inbox />
            </div>
          </div>
          <div class="border-t border-gray-200 mt-4"></div>
        </div> -->

      </div>
      
       <!-- Loan Section -->
    <div class="mx-auto w-full mt-10 bg-white rounded-xl shadow-sm">

      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-5 gap-4">
        <h2 class="text-lg font-semibold text-gray-900">Recent Loan Request</h2>
        <NuxtLink 
          to="/userUI/lender/marketplace" 
          class="px-4 py-2 bg-gray-700 hover:bg-gray-900 text-white font-semibold rounded-lg transition-colors duration-200 text-center"
        >
          View All
        </NuxtLink>
      </div>

      <!-- Loan Display -->
      <div class="p-5">
        <div class="space-y-6">
          <div 
            v-for="loan in loans" 
            :key="loan.id" 
            class="bg-gray-50 p-4 sm:p-6 rounded-xl"
          >
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm">
              <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <!-- Borrower Info -->
                <div class="flex items-center gap-4 min-w-0 flex-1">

                  <div class="flex-shrink-0 flex items-center justify-center rounded-full w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold text-lg">
                    {{ loan.initials }}
                  </div>
                  
                  <div class="min-w-0 flex-1">
                    <h4 class="font-semibold text-gray-900 text-lg sm:text-xl truncate">
                      {{ loan.borrowerName }}
                    </h4>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mt-1">
                      <p class="text-green-600 text-sm font-medium">
                        Credit Score: {{ loan.creditScore }}
                      </p>
                      <span 
                        :class="[
                          'px-2 py-1 rounded-full text-xs font-medium',
                          loan.riskLevel === 'Low' ? 'bg-green-100 text-green-800' :
                          loan.riskLevel === 'Medium' ? 'bg-yellow-100 text-yellow-800' :
                          'bg-red-100 text-red-800'
                        ]"
                      >
                        {{ loan.riskLevel }} Risk
                      </span>
                    </div>

                  </div>
                </div>

                <!-- Loan Details -->
                <div class="w-full lg:w-auto">

                  <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                      <p class="text-gray-500 text-xs sm:text-sm mb-1">Amount</p>
                      <p class="text-gray-900 font-semibold text-lg sm:text-xl">
                        ${{ formatCurrency(loan.amount) }}
                      </p>
                    </div>

                    <div>
                      <p class="text-gray-500 text-xs sm:text-sm mb-1">Interest Rate</p>
                      <p class="text-gray-900 font-semibold text-lg sm:text-xl">
                        {{ loan.interestRate }}%
                      </p>
                    </div>

                    <div>
                      <p class="text-gray-500 text-xs sm:text-sm mb-1">Term</p>
                      <p class="text-gray-900 font-semibold text-lg sm:text-xl">
                        {{ loan.term }}
                      </p>
                    </div>

                  </div>
                </div>
              </div>

              <!-- Loan Purpose and Actions -->
              <div class="mt-6 pt-6 border-t border-gray-200">

                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-4">
                  <div class="flex-1 min-w-0">
                    <h4 class="text-gray-700 text-base sm:text-lg font-medium mb-2">
                      Reason for loan:
                    </h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                      {{ loan.purpose }}
                    </p>
                  </div>

                  <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <NuxtLink 
                      to="/userUI/lender/loanPreview" 
                      class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition-colors duration-200 text-center"
                    >
                      View Details
                    </NuxtLink>
                    
                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

        <!-- Load More Button -->
        <!-- <div class="text-center mt-8" v-if="loans.length > 0">
          <button 
            @click="loadMoreLoans"
            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors duration-200"
          >
            Load More Opportunities
          </button>
        </div> -->

        <!-- Empty State -->
        <div v-if="loans.length === 0" class="text-center py-12">
          <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No Opportunities Available</h3>
          <p class="text-gray-500">Check back later for new investment opportunities.</p>
        </div>

      </div>
    </div>


    </div>


    




</template>



<script setup>
import closeEye from '~/components/icons/closeEye.vue'
import openEye from '~/components/icons/openEye.vue'
import wallet from '~/components/icons/wallet.vue'
import inbox from '~/components/icons/inbox.vue'
import { ref } from 'vue'
import { lenderProfileData } from '~/composables/lenderProfileData'
import { useRuntimeConfig } from '#app'
import { useAuthLender } from '~/composables/useAuthLender'

definePageMeta({
  layout: 'lender',
  middleware: 'authlender'
});

const {id}=await lenderProfileData()
const token=useAuthLender()
const config=useRuntimeConfig()

const amount=ref()

onMounted(async()=> {
  try{
    const res= await $fetch(`${config.public.sanctum.baseUrl}/getLenderBalance/${id}`, {
       headers: {
          Authorization: `Bearer ${token.value}`,
      }, 
    })

    if (res) {
      amount.value=res.balance
    }
  } catch (error) {
  console.error('Failed to fetch loans:', error)
}
})





// Fixed: Properly define transactions as an array
const transactions = ref([
  {
    id: 1,
    type: 'received',
    amount: 2500.00,
    description: 'Salary Payment',
    date: '2025-06-07',
    time: '09:30 AM',
    status: 'completed',
    from: 'Company Inc.',
    category: 'Income'
  },
  {
    id: 2,
    type: 'sent',
    amount: 850.00,
    description: 'Rent Payment',
    date: '2025-06-06',
    time: '02:15 PM',
    status: 'completed',
    to: 'Property Management',
    category: 'Housing'
  }
]);

// Format amount function
const formatAmount = (amount) => {
  return amount.toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
};

// Icons (using Lucide)
const icons = {
  wallet: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>',
  arrowUpRight: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 7 10 10"/><path d="M7 17V7h10"/></svg>',
  arrowDownLeft: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 17 7 7"/><path d="M17 7v10H7"/></svg>',
  creditCard: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>',
  trendingUp: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22,7 13.5,15.5 8.5,10.5 2,17"/><polyline points="16,7 22,7 22,13"/></svg>',
  eye: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>',
  eyeOff: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-.722-3.25"/><path d="M2 2l20 20"/><path d="M6.71 6.71C4.49 8.4 3 10.9 3 12c0 0 3 7 10 7 .847 0 1.716-.092 2.533-.274"/><path d="m10 10-1.5 2C7.619 11.383 7 10.748 7 10c0-.748.619-1.383 1.5-1H10z"/><path d="M17.18 5.18C15.234 4.14 13.244 4 12 4c-7 0-10 7-10 7a31.147 31.147 0 0 0 .643 1.265"/><path d="M19.297 13.88C19.816 13.151 20 12.518 20 12c0 0-3-7-10-7-.42 0-.86.042-1.311.125"/></svg>',
  refreshCw: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M3 21v-5h5"/></svg>',
  download: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>',
  search: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>'
};

// type IconName = keyof typeof icons;

const getIcon = (iconName) => {
  return icons[iconName] || '';
};
// Loans data array
const loans = ref([
  {
    id: 1,
    borrowerName: 'John Son',
    initials: 'JS',
    creditScore: 80,
    amount: 1000,
    interestRate: 5.50,
    term: '3 months',
    duration: '90 days',
    purpose: 'Education expenses for MBA program. Looking to advance career opportunities and increase earning potential in the long term.',
    riskLevel: 'Medium'
  },
  {
    id: 2,
    borrowerName: 'Sarah Mitchell',
    initials: 'SM',
    creditScore: 75,
    amount: 2500,
    interestRate: 6.25,
    term: '6 months',
    duration: '180 days',
    purpose: 'Small business expansion to purchase new equipment and increase production capacity for growing customer demand.',
    riskLevel: 'Medium'
  },
  {
    id: 3,
    borrowerName: 'David Rodriguez',
    initials: 'DR',
    creditScore: 85,
    amount: 5000,
    interestRate: 4.75,
    term: '12 months',
    duration: '365 days',
    purpose: 'Home improvement project including kitchen renovation and energy-efficient upgrades to increase property value.',
    riskLevel: 'Low'
  },
  {
    id: 4,
    borrowerName: 'Emily Chen',
    initials: 'EC',
    creditScore: 70,
    amount: 1500,
    interestRate: 7.00,
    term: '4 months',
    duration: '120 days',
    purpose: 'Medical expenses for planned surgery and recovery period. Established payment history and stable employment.',
    riskLevel: 'Medium'
  }
]);

// Format currency function
const formatCurrency = (amount) => {
  return amount.toLocaleString('en-US');
};

// Load more loans function (placeholder)
const loadMoreLoans = () => {
  console.log('Loading more loans...');
  // In a real app, this would fetch more data from an API
};
</script>
<template>
  <div class="space-y-2">
    <div
      v-if="flashError.length"
      class="fixed top-20 right-5 max-h-[80vh] w-[300px] overflow-y-auto space-y-4 z-50"
    >
      <div
        v-for="(msg, index) in flashError"
        :key="index"
        class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow"
      >
        {{ msg }}
      </div>
    </div>
  </div>

  <div class="p-4 md:p-8 min-h-full">
    <div class="mx-auto w-full md:flex md:justify-between gap-x-6">
      <!-- Total Balance Card -->
      <div
        class="border-1 border-gray-300 shadow-md bg-gradient-to-br from-[#0a0e2a] via-[#0c1e3a] to-[#081021] w-full rounded-2xl p-6 flex flex-row justify-center gap-x-5 lg:gap-x-100"
      >
        <!--credit score-->
        <div>
          <div class="flex justify-between mt-5">
            <h2 class="text-lg font-semibold text-gray-100">Credit Score</h2>
            <div
              class="text-gray-100 w-10 h-10 bg-gray-300 rounded-full px-2 py-2 text-center"
            >
              i
            </div>
          </div>

          <div class="relative my-6 w-40 h-40 mx-auto">
            <svg
              class="max-w-full max-h-full rotate-[-90deg]"
              viewBox="0 0 36 36"
            >
              <!-- Background circle -->
              <path
                d="M18 2.0845
                      a 15.9155 15.9155 0 0 1 0 31.831
                      a 15.9155 15.9155 0 0 1 0 -31.831"
                fill="none"
                stroke="#e5e7eb"
                stroke-width="3.8"
              />
              <!-- Progress circle -->
              <path
                d="M18 2.0845
                      a 15.9155 15.9155 0 0 1 0 31.831
                      a 15.9155 15.9155 0 0 1 0 -31.831"
                fill="none"
                :stroke="color"
                stroke-width="3.8"
                stroke-linecap="round"
                :stroke-dasharray="circumference"
                :stroke-dashoffset="dashOffset"
              />
            </svg>

            <div
              class="absolute top-1/6 left-1/2 transform -translate-x-1/2 translate-y-1/2 text-center"
            >
              <div class="text-2xl font-bold text-gray-100">{{ score }}</div>
              <div class="text-sm text-gray-100">{{ label }}</div>
            </div>
          </div>

          <!-- Range Indicator Line -->
          <div class="mt-4 w-full">
            <svg viewBox="0 0 100 4" class="w-full h-2">
              <rect
                x="0"
                y="0"
                width="100"
                height="4"
                rx="2"
                ry="2"
                fill="#e5e7eb"
              />
              <rect
                x="0"
                y="0"
                :width="score"
                height="4"
                rx="2"
                ry="2"
                :fill="color"
              />
            </svg>
          </div>

          <div class="flex justify-center gap-x-50 text-sm text-gray-100 mt-1">
            <span>Poor</span>
            <span>Excellent</span>
          </div>
        </div>
        <!--total balance-->
        <div class="flex-col space-y-10">
          <div class="border-b-1 border-gray-300">
            <h2 class="text-lg font-normal text-gray-100">Available balance</h2>
            <p
              v-if="amount"
              class="text-3xl font-bold text-gray-100 mt-2 md:ml-20 mb-5"
            >
              ${{ amount.balance.toFixed(2) }}
            </p>
          </div>

          <div class="flex justify-start gap-x-20">
            <div>
              <h2 class="text-nd font-normal text-gray-100">Active Loan</h2>
              <p class="text-xl font-bold text-yellow-400 mt-2">
                {{ totalLoanCount }}
              </p>
            </div>
            <div>
              <h2 class="text-md font-normal text-gray-100">Active Loan</h2>
              <p class="text-xl font-bold text-yellow-400 mt-2">
                {{ activeLoanCount }}
              </p>
            </div>
            <div>
              <h2 class="text-md font-normal text-gray-100">Completed Loan</h2>
              <p class="text-xl font-bold text-yellow-400 mt-2">
                {{ completedLoanCount }}
              </p>
            </div>
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
    </div>

    <!-- Loan Section -->
  </div>
</template>

<script setup>
import { borrowerProfileData } from "~/composables/borrowerProfileData";

import { ref, computed, onMounted } from "vue";
import { useAuth } from "@/composables/useAuth";
import { useRuntimeConfig } from "#app";
import { useFlashError } from "@/composables/uaeFlashError";
import { loanTracking } from "~/composables/loanTracking";

definePageMeta({
  layout: "borrower",
  middleware: "auth",
});

//

const { setError, flashError } = useFlashError();
console.log(useFlashError);
// get borrowr data
const { credit_score, id } = await borrowerProfileData();
const token = useAuth();
const config = useRuntimeConfig();
const amount = ref();
const loans = ref();

onMounted(async () => {
  try {
    await loanTracking();
    const res = await $fetch(
      `${config.public.apiBase}/getBorrowerBalance/${id}`,
      {
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      }
    );

    if (res) {
      amount.value = res.balance;
    }
  } catch (error) {
    console.error("Failed to fetch loans:", error);
  }

  try {
    const res1 = await $fetch(
      `${config.public.apiBase}/getAllLoanAfterApproveforBorrower/${id}`,
      {
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      }
    );

    if (res1) {
      loans.value = res1.loan;
    }
  } catch (error) {
    console.error("Failed to fetch loans:", error);
  }
});

// total funded
const totalLoanCount = computed(() => {
  return loans.value?.length || 0;
});

// Active loans count
const activeLoanCount = computed(() => {
  return (
    loans.value?.filter((loan) => loan.status?.toLowerCase() === "active")
      .length || 0
  );
});

// Completed loans count
const completedLoanCount = computed(() => {
  return (
    loans.value?.filter((loan) => loan.status?.toLowerCase() === "completed")
      .length || 0
  );
});

// Late loans count
const lateLoanCount = computed(() => {
  return (
    loans.value?.filter((loan) => loan.status?.toLowerCase() === "late")
      .length || 0
  );
});

// Icons (using Lucide)
const icons = {
  wallet:
    '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>',
  arrowUpRight:
    '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 7 10 10"/><path d="M7 17V7h10"/></svg>',
  arrowDownLeft:
    '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 17 7 7"/><path d="M17 7v10H7"/></svg>',
  creditCard:
    '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>',
  trendingUp:
    '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22,7 13.5,15.5 8.5,10.5 2,17"/><polyline points="16,7 22,7 22,13"/></svg>',
  eye: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>',
  eyeOff:
    '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-.722-3.25"/><path d="M2 2l20 20"/><path d="M6.71 6.71C4.49 8.4 3 10.9 3 12c0 0 3 7 10 7 .847 0 1.716-.092 2.533-.274"/><path d="m10 10-1.5 2C7.619 11.383 7 10.748 7 10c0-.748.619-1.383 1.5-1H10z"/><path d="M17.18 5.18C15.234 4.14 13.244 4 12 4c-7 0-10 7-10 7a31.147 31.147 0 0 0 .643 1.265"/><path d="M19.297 13.88C19.816 13.151 20 12.518 20 12c0 0-3-7-10-7-.42 0-.86.042-1.311.125"/></svg>',
  refreshCw:
    '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M3 21v-5h5"/></svg>',
  download:
    '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>',
  search:
    '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>',
};

const getIcon = (iconName) => {
  return icons[iconName] || "";
};

// 🟩 Test score (change to see different results)
const score = ref(credit_score ?? 0);

// 🟦 Circle geometry
const r = 15.9155;
const circumference = 2 * Math.PI * r;

// 🔁 Dynamic offset for circle
const dashOffset = computed(() => ((100 - score.value) / 100) * circumference);

// 🎨 Color based on score
const color = computed(() => {
  if (score.value < 50) return "#ef4444"; // red-500
  if (score.value < 70) return "#facc15"; // yellow-400
  if (score.value < 85) return "#3b82f6"; // blue-500
  return "#10b981"; // green-500
});

// 🏷️ Label
const label = computed(() => {
  if (score.value < 50) return "Poor";
  if (score.value < 70) return "Fair";
  if (score.value < 85) return "Good";
  return "Excellent";
});
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <!-- Transaction History -->
    <div v-if="loading">Loading......</div>
    <div v-else>
      <div v-if="transactions" class="p-4 sm:p-6 w-full mt-6 md:mt-0">
        <p class="text-lg font-semibold text-gray-700 mb-4">
          Transactions Record
        </p>

        <div
          v-for="transaction in transactions"
          :key="transaction.id"
          class="p-4 hover:bg-gray-50 bg-white transition-all border-b border-gray-300 last:border-b-0"
        >
          <div class="flex flex-wrap items-start justify-between gap-4">
            <!-- Left: Icon + Description -->
            <div class="flex items-start gap-4 w-full sm:w-auto flex-1">
              <!-- Icon -->
              <div
                :class="[
                  'p-3 rounded-full shrink-0',
                  transaction.type === 'fund'
                    ? 'bg-green-100 text-green-600'
                    : 'bg-red-100 text-red-600',
                ]"
              >
                <span
                  class="w-5 h-5 block"
                  v-html="
                    transaction.type === 'fund'
                      ? getIcon('arrowDownLeft')
                      : getIcon('arrowUpRight')
                  "
                ></span>
              </div>

              <!-- Description -->
              <div class="flex flex-col gap-1">
                <h4 class="font-semibold text-gray-900">
                  {{ transaction.lender?.first_name }}
                  {{ transaction.lender?.last_name }}
                </h4>
                <div
                  class="flex flex-wrap gap-x-2 gap-y-1 text-sm text-gray-600 items-center"
                >
                  <span>{{ formatDateTime(transaction.created_at) }}</span>
                  <span>|</span>

                  <!-- <span 
                                :class="[
                                  'px-2 py-0.5 rounded-full text-xs',
                                  transaction.status === 'completed' 
                                  ? 'bg-green-100 text-green-800' 
                                  : 'bg-yellow-100 text-yellow-800'
                                ]"
                              >
                                {{ transaction.status }}
                              </span> -->
                </div>
              </div>
            </div>

            <!-- Right: Amount + Category -->
            <div class="text-right w-full sm:w-auto">
              <p
                :class="[
                  'text-lg font-semibold',
                  transaction.type === 'fund'
                    ? 'text-green-600'
                    : 'text-red-600',
                ]"
              >
                {{ transaction.type === "fund" ? "+" : "-" }}${{
                  formatAmount(transaction.amount)
                }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRuntimeConfig } from "#app";
import { lenderProfileData } from "~/composables/lenderProfileData";
import { useAuth } from "~/composables/useAuth";
import { borrowerProfileData } from "~/composables/borrowerProfileData";

definePageMeta({
  layout: "borrower",
  middleware: "auth",
});

const token = useAuth();
const config = useRuntimeConfig();
const { id } = await borrowerProfileData();

const transactions = ref();
const loading = ref(true);

onMounted(async () => {
  try {
    const res = await $fetch(
      `${config.public.apiBase}/transactionForBorrower/${id}`,
      {
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      }
    );
    if (res.transaction) {
      transactions.value = res.transaction;
    }
  } catch (error) {
    console.error("Failed to fetch loans:", error);
  } finally {
    loading.value = false;
  }
});

const formatDateTime = (timestamp) => {
  const date = new Date(timestamp);
  const yyyy = date.getFullYear();
  const mm = String(date.getMonth() + 1).padStart(2, "0");
  const dd = String(date.getDate()).padStart(2, "0");
  const hh = String(date.getHours()).padStart(2, "0");
  const min = String(date.getMinutes()).padStart(2, "0");
  return `${yyyy}-${mm}-${dd} ${hh}:${min}`;
};

// Format amount function
const formatAmount = (amount) => {
  return amount.toLocaleString("en-US", {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });
};

// Icons (using Lucide)
const getIcon = (iconName) => {
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
  return icons[iconName] || "";
};
</script>

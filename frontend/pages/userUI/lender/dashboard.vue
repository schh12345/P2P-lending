<template>
  <div class="p-4 md:p-8 min-h-full">
    <div class="mx-auto w-full md:flex md:justify-between gap-x-6">
      <!-- Total Balance Card -->
      <div
        class="min-h-[300px] border-1 border-gray-300 shadow-md bg-gradient-to-br from-blue-900 to-teal-700 w-full rounded-2xl p-6 flex flex-col justify-between space-y-5"
      >
        <div class="flex justify-between border-b border-gray-200">
          <div>
            <h2 class="text-md font-normal text-gray-100">Available balance</h2>
            <p v-if="amount" class="text-3xl font-bold text-gray-100 mt-2">
              ${{ amount.balance.toFixed(2) }}
            </p>
          </div>
          <div class="mt-5 mb-10 rounded-xl w-10 h-10 bg-yellow-500 px-2 py-2">
            <wallet />
          </div>
        </div>
        <div class="flex justify-start gap-x-20">
          <div>
            <h2 class="text-sm font-normal text-gray-100">Total Fund</h2>
            <p class="text-xl font-bold text-yellow-400 mt-2">
              {{ totalFundCount }}
            </p>
          </div>
          <div>
            <h2 class="text-sm font-normal text-gray-100">Active Fund</h2>
            <p class="text-xl font-bold text-yellow-400 mt-2">
              {{ activeFundCount }}
            </p>
          </div>
          <div>
            <h2 class="text-sm font-normal text-gray-100">Completed Fund</h2>
            <p class="text-xl font-bold text-yellow-400 mt-2">
              {{ completedFundCount }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Loan Section -->
  </div>
</template>

<script setup>
import wallet from "~/components/icons/wallet.vue";
import { ref } from "vue";
import { lenderProfileData } from "~/composables/lenderProfileData";
import { useRuntimeConfig } from "#app";
import { useAuthLender } from "~/composables/useAuthLender";

definePageMeta({
  layout: "lender",
  middleware: "authlender",
});

const { id } = await lenderProfileData();
const token = useAuthLender();
const config = useRuntimeConfig();
const loans = ref();
const amount = ref();

onMounted(async () => {
  try {
    const res = await $fetch(
      `${config.public.apiBase}/getLenderBalance/${id}`,
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
      `${config.public.apiBase}/getAllLoanAfterApproveforLender/${id}`,
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
const totalFundCount = computed(() => {
  return loans.value?.length || 0;
});

// Active loans count
const activeFundCount = computed(() => {
  return (
    loans.value?.filter((loan) => loan.status?.toLowerCase() === "active")
      .length || 0
  );
});

// Completed loans count
const completedFundCount = computed(() => {
  return (
    loans.value?.filter((loan) => loan.status?.toLowerCase() === "completed")
      .length || 0
  );
});

// Late loans count
const lateFundCount = computed(() => {
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

// type IconName = keyof typeof icons;

const getIcon = (iconName) => {
  return icons[iconName] || "";
};
// Loans data array
</script>

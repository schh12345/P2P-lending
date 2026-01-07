<template>
  <div class="max-w-6xl mx-auto px-4 py-12 space-y-8">
    <!-- Back Button -->
    <div class="bg-white p-5 rounded-lg w-1/5">
      <NuxtLink
        to="/userUI/lender/fundRecord"
        class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium"
      >
        ← Back to Fund Records
      </NuxtLink>
    </div>

    <div v-if="loading" class="text-center text-gray-500">
      Loading payback details...
    </div>

    <div v-else-if="fund" class="bg-white rounded-2xl shadow p-6 space-y-6">
      <h2 class="text-2xl font-bold text-gray-800">Payback Details</h2>

      <!--borrower info-->
      <div class="border-b pb-4 flex items-center space-x-4">
        <!--show the initail word of firstname & lastname of borrower if profile_path did not upload-->
        <div
          v-if="!fund.borrower?.profile_picture"
          :class="[
            'flex-shrink-0 flex items-center justify-center rounded-full w-12 h-12 text-white font-bold text-lg',
            getRandomBg(fund.borrower?.first_name),
          ]"
        >
          {{ fund.borrower?.first_name.charAt(0).toUpperCase()
          }}{{ fund.borrower?.last_name.charAt(0).toUpperCase() }}
        </div>
        <!--show profile path-->
        <div
          v-else
          class="relative rounded-full w-10 h-10 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 outline-none overflow-hidden"
        >
          <img
            :src="fullUrl(fund.borrower?.profile_picture)"
            alt="Profile"
            class="object-cover w-full h-full rounded-full"
          />
        </div>
        <div>
          <p class="text-gray-800 font-medium">
            {{ fund.borrower?.first_name }} {{ fund.borrower?.last_name }}
          </p>
        </div>
      </div>

      <!-- Fund Transaction Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
        <div><strong>Amount Funded:</strong> ${{ fund.amount }}</div>
        <div><strong>Interest Rate:</strong> {{ fund.interest_rate }}%</div>
        <div><strong>Duration:</strong> {{ fund.duration }}Days</div>
        <div><strong>Total Payback:</strong> ${{ fund.total }}</div>
        <div><strong>Start Date:</strong> {{ fund.start_date }}</div>
        <div><strong>Due Date:</strong> {{ fund.payment_date }}</div>
        <div>
          <strong>Paid At:</strong> {{ formatDateTime(fund.updated_at) }}
        </div>
        <div v-if="fund.lateDay">
          <strong>Was Late:</strong>
          <span class="text-red-600 font-semibold">{{ fund.lateDay }}Days</span>
        </div>
      </div>

      <!-- Optional Note or Message -->
      <div v-if="fund.note" class="mt-4 p-4 bg-gray-50 rounded-lg">
        <p class="text-sm text-gray-600"><strong>Lender's Note:</strong></p>
        <p class="text-gray-800">{{ fund.note }}</p>
      </div>
    </div>

    <div v-else class="text-center text-red-500">No fund detail found.</div>
  </div>
</template>

<script setup>
definePageMeta({
  layout: "lender",
  middleware: "authlender",
});

import { useRoute, useRuntimeConfig } from "#app";
import { ref, onMounted } from "vue";
import { useAuthLender } from "~/composables/useAuthLender";

const config = useRuntimeConfig();
const route = useRoute();
const token = useAuthLender();
const loading = ref(true);
const fund = ref(null);

onMounted(async () => {
  try {
    const res = await $fetch(
      `${config.public.apiBase}/getLoanAfterApproveforBorrower/${route.params.loanId}`,
      {
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      }
    );

    fund.value = res.loan;
  } catch (error) {
    console.error("Error fetching fund detail:", error);
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

const fullUrl = (path) => `http://localhost:8001${path}`;
const bgColor = [
  "bg-blue-600",
  "bg-purple-700",
  "bg-green-600",
  "bg-pink-500",
  "bg-yellow-500",
  "bg-red-600",
];
// Deterministic hash from name to keep color stable
const getRandomBg = (first_name) => {
  return first_name
    ? bgColor[first_name.charCodeAt(0) % bgColor.length]
    : "bg-gray-400";
};
</script>

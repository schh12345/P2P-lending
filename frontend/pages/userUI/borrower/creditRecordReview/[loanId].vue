<template>
  <div class="max-w-7xl mx-auto px-4 py-12 space-y-8 rounded-xl">
    <!-- Back Button -->
    <div class="bg-white p-4 rounded-lg shadow w-fit">
      <NuxtLink
        to="/userUI/borrower/creditRecord"
        class="inline-flex items-center text-teal-700 hover:text-teal-900 font-medium"
      >
        ← Back to Fund Records
      </NuxtLink>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="text-center text-gray-500">
      Loading payback details...
    </div>

    <!-- Main Content -->
    <div v-else-if="fund" class="bg-white rounded-2xl shadow-lg p-6 space-y-6">
      <h2 class="text-2xl font-bold text-teal-800">Payback Details</h2>

      <!-- lender Info -->
      <div class="border-b pb-4 flex items-center space-x-4">
        <!--show the initail word of firstname & lastname of borrower if profile_path did not upload-->
        <div
          v-if="!fund.lender?.profile_picture"
          :class="[
            'flex-shrink-0 flex items-center justify-center rounded-full w-12 h-12 text-white font-bold text-lg',
            getRandomBg(fund.lender?.first_name),
          ]"
        >
          {{ fund.lender?.first_name.charAt(0).toUpperCase()
          }}{{ fund.lender?.last_name.charAt(0).toUpperCase() }}
        </div>
        <!--show profile path-->
        <div
          v-else
          class="relative rounded-full w-10 h-10 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 outline-none overflow-hidden"
        >
          <img
            :src="fullUrl(fund.lender?.profile_picture)"
            alt="Profile"
            class="object-cover w-full h-full rounded-full"
          />
        </div>
        <div>
          <p class="text-gray-800 font-medium">
            {{ fund.lender?.first_name }} {{ fund.lender?.last_name }}
          </p>
        </div>
      </div>

      <!-- Fund Transaction Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
        <div class="bg-gray-50 rounded-lg p-4">
          <strong class="text-gray-500">Amount Funded:</strong>
          <p class="text-teal-900 font-semibold">${{ fund.amount }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <strong class="text-gray-500">Interest Rate:</strong>
          <p class="text-teal-900 font-semibold">{{ fund.interest_rate }}%</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <strong class="text-gray-500">Duration:</strong>
          <p class="text-teal-900 font-semibold">{{ fund.duration }} Days</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <strong class="text-gray-500">Total Payback:</strong>
          <p class="text-green-700 font-bold">${{ fund.total }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <strong class="text-gray-500">Start Date:</strong>
          <p class="text-teal-900">{{ fund.start_date }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <strong class="text-gray-500">Due Date:</strong>
          <p class="text-teal-900">{{ fund.payment_date }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <strong class="text-gray-500">Paid At:</strong>
          <p class="text-teal-900">{{ formatDateTime(fund.updated_at) }}</p>
        </div>
        <div v-if="fund.lateDay" class="bg-gray-50 rounded-lg p-4">
          <strong class="text-gray-500">Was Late:</strong>
          <p class="text-red-600 font-semibold">{{ fund.lateDay }} Days</p>
        </div>
      </div>

      <!-- Optional Note -->
      <div
        v-if="fund.note"
        class="bg-yellow-50 p-4 rounded-lg border border-yellow-200"
      >
        <p class="text-sm text-yellow-700 font-medium mb-1">Lender's Note:</p>
        <p class="text-gray-800">{{ fund.note }}</p>
      </div>
    </div>

    <!-- No Data -->
    <div v-else class="text-center text-red-500">No fund detail found.</div>
  </div>
</template>

<script setup>
import { useRoute, useRuntimeConfig } from "#app";
import { ref, onMounted } from "vue";
import { useAuth } from "~/composables/useAuth";

definePageMeta({
  layout: "borrower",
  middleware: "auth",
});

const config = useRuntimeConfig();
const route = useRoute();
const token = useAuth();
const loading = ref(true);
const fund = ref();

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
    if (res && res.loan) {
      fund.value = res.loan;
      console.log(fund.value);
    }
  } catch (error) {
    console.error("Error fetching payback detail:", error);
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

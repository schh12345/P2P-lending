<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <!--display loan-->
    <div class="md:flex md:flex-row md:justify-between flex flex-col">
      <!--total loan-->
      <div
        class="p-10 bg-white rounded-lg border-1 border-gray-100 flex justify-start items-center gap-x-5"
      >
        <img :src="totalLoan" alt="total loan image" class="w-auto h-auto" />
        <div>
          <p class="text-gray-600 text-md">Total Loans</p>
          <!--fetch from table laon of user-->
          <p class="text-4xl font-bold text-gray-900">{{ totalLoanCount }}</p>
        </div>
      </div>

      <!--active loan-->
      <div
        class="p-10 bg-white rounded-lg border-1 border-gray-100 flex justify-start items-center gap-x-5"
      >
        <img :src="activeLoan" alt="active loan image" class="w-auto h-auto" />
        <div>
          <p class="text-gray-600 text-md">Active Loans</p>
          <!--fetch from table laon of user-->
          <p class="text-4xl font-bold text-gray-900">{{ activeLoanCount }}</p>
        </div>
      </div>

      <!--Completed loan-->
      <div
        class="p-10 bg-white rounded-lg border-1 border-gray-100 flex justify-start items-center gap-x-5"
      >
        <img
          :src="completedLoan"
          alt="completed loan image"
          class="w-auto h-auto"
        />
        <div>
          <p class="text-gray-600 text-md">Paidback Loans</p>
          <!--fetch from table laon of user-->
          <p class="text-4xl font-bold text-gray-900">
            {{ completedLoanCount }}
          </p>
        </div>
      </div>
    </div>

    <div class="rounded-lg overflow-hidden space-y-5">
      <div v-if="loading" class="text-center text-gray-500">Loading...</div>
      <!-- Tab Navigation -->
      <div v-else>
        <div
          class="bg-white flex flex-wrap border-b-2 border-gray-200 text-sm sm:text-base"
        >
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="[
              'px-4 py-3 sm:px-6 sm:py-4 font-medium transition-colors duration-200 ease-in-out',
              activeTab === tab.id
                ? 'text-blue-600 border-b-2 border-blue-600'
                : 'text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-300',
            ]"
          >
            {{ tab.name }}
          </button>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
          <table
            class="min-w-full divide-y divide-gray-200 border-separate border-spacing-y-5"
          >
            <thead class="bg-gray-50">
              <tr>
                <th
                  v-for="header in tableHeaders"
                  :key="header.key"
                  scope="col"
                  class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap sm:px-6"
                >
                  {{ header.label }}
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr
                class="space-y-10"
                v-for="item in filteredTableData"
                :key="item.id"
                :class="[
                  item.status === 'late' ? 'bg-red-50' : 'bg-white',
                  'rounded-xl shadow-sm transition-all duration-200 ease-in-out' /* Added for subtle row styling */,
                ]"
              >
                <td class="px-4 py-3 sm:px-6 whitespace-nowrap">
                  <div class="flex items-center">
                    <!--show the initail word of firstname & lastname of borrower if profile_path did not upload-->
                    <div
                      v-if="!item.lender?.profile_picture"
                      :class="[
                        'flex-shrink-0 flex items-center justify-center rounded-full w-12 h-12 text-white font-bold text-lg',
                        getRandomBg(item.lender?.first_name),
                      ]"
                    >
                      {{ item.lender?.first_name.charAt(0).toUpperCase()
                      }}{{ item.lender?.last_name.charAt(0).toUpperCase() }}
                    </div>
                    <!--show profile path-->
                    <div
                      v-else
                      class="relative rounded-full w-10 h-10 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 outline-none overflow-hidden"
                    >
                      <img
                        :src="fullUrl(item.lender?.profile_picture)"
                        alt="Profile"
                        class="object-cover w-full h-full rounded-full"
                      />
                    </div>
                    <div class="ml-3 text-sm font-medium text-gray-900">
                      {{ item.lender?.first_name }} {{ item.lender?.last_name }}
                    </div>
                  </div>
                </td>
                <td
                  class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900"
                >
                  {{ item.amount }}
                </td>
                <td
                  class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900"
                >
                  {{ item.interest_rate }}
                </td>
                <td
                  class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900"
                >
                  {{ item.duration }}
                </td>
                <td
                  class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900"
                >
                  {{ item.start_date }}
                </td>
                <td
                  class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900"
                >
                  {{ item.payment_date }}
                </td>
                <td
                  class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900"
                >
                  {{ item.total }}
                </td>
                <td
                  class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900"
                >
                  <span
                    :class="[
                      'px-3 py-1 rounded-full text-xs font-semibold',
                      item.status === 'Active'
                        ? 'bg-green-100 text-green-800'
                        : item.status === 'Completed'
                        ? 'bg-blue-100 text-blue-800'
                        : 'bg-red-100 text-red-800',
                    ]"
                  >
                    {{
                      item.status === "Late"
                        ? `${item.status} (${item.lateDay} Days)`
                        : item.status
                    }}
                  </span>
                </td>

                <td
                  class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-100"
                >
                  <NuxtLink
                    :to="`/userUI/borrower/payback/${item.id}`"
                    v-if="item.status !== 'Completed'"
                    class="bg-green-500 hover:bg-green-600 py-2 px-5 rounded-xl"
                  >
                    Pay Now
                  </NuxtLink>
                  <NuxtLink
                    :to="`/userUI/borrower/creditRecordReview/${item.id}`"
                    v-if="item.status === 'Completed'"
                    class="bg-blue-500 hover:bg-blue-600 py-2 px-5 rounded-xl"
                  >
                    Review
                  </NuxtLink>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
definePageMeta({
  layout: "borrower",
  middleware: "auth",
});

import totalLoan from "~/assets/image/totalLoan.png";
import activeLoan from "~/assets/image/activities.png";
import completedLoan from "~/assets/image/completed-task.png";
import { useAuth } from "~/composables/useAuth";
import { useRuntimeConfig, useRoute } from "#app";
import { ref, onMounted, computed } from "vue";
import { borrowerProfileData } from "~/composables/borrowerProfileData";

const fullUrl = (path) => `http://localhost:8001${path}`;
const { id } = await borrowerProfileData();
const token = useAuth();
const config = useRuntimeConfig();
const loans = ref();
const loading = ref(true);
onMounted(async () => {
  try {
    const res = await $fetch(
      `${config.public.apiBase}/getAllLoanAfterApproveforBorrower/${id}`,
      {
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      }
    );

    if (res) {
      loans.value = res.loan;
    }
  } catch (error) {
    console.error("Failed to fetch loans:", error);
  } finally {
    loading.value = false;
  }
});

const tabs = ref([
  { id: "all", name: "All Loans" },
  { id: "active", name: "Active" },
  { id: "completed", name: "Paidback" },
  { id: "late", name: "Late" },
]);

const activeTab = ref("all");

const tableHeaders = ref([
  { key: "lender", label: "Funded by" },
  { key: "amount", label: "Amount" },
  { key: "interestRate", label: "Interest Rate" },
  { key: "term", label: "Term" },
  { key: "startDate", label: "Start Date" },
  { key: "dueDate", label: "Due Date" },
  { key: "total", label: "Total" },
  { key: "status", label: "Status" },
  { key: "action", label: "action" },
]);

const filteredTableData = computed(() => {
  if (!loans.value) return [];

  if (activeTab.value === "all") {
    return loans.value;
  }

  return loans.value.filter((item) => {
    if (activeTab.value === "late") {
      return item.status === "late";
    }
    return item.status?.toLowerCase() === activeTab.value;
  });
});

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

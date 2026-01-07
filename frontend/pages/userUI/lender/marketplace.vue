<template>
  <div class="p-4 md:p-8">
    <!--show loans-->
    <div class="max-w-7xl mx-auto bg-white">
      <!-- Loan Section -->
      <div class="mx-auto max-w-7xl mt-10 bg-white rounded-xl shadow-sm">
        <!-- <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-5 gap-4">
                        <h2 class="text-lg font-semibold text-gray-900">Recommended Opportunities</h2>
                        <NuxtLink 
                        to="#" 
                        class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors duration-200 text-center"
                        >
                        View All
                        </NuxtLink>
                    </div> -->

        <!-- Loan Display -->
        <div class="p-5">
          <div v-if="loading">Loading the data</div>
          <div v-else class="space-y-6">
            <div v-if="loans.length === 0">No loan records found.</div>
            <div v-else>
              <div
                v-for="loan in loans"
                :key="loan.id"
                class="bg-gray-50 p-4 sm:p-6 rounded-xl"
              >
                <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm">
                  <div
                    class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6"
                  >
                    <!-- Borrower Info -->
                    <div class="flex items-center gap-4 min-w-0 flex-1">
                      <!--show the initail word of firstname & lastname of borrower if profile_path did not upload-->
                      <div
                        v-if="!loan.borrower?.profile_picture"
                        :class="[
                          'flex-shrink-0 flex items-center justify-center rounded-full w-12 h-12 text-white font-bold text-lg',
                          getRandomBg(loan.borrower?.first_name),
                        ]"
                      >
                        {{ loan.borrower?.first_name.charAt(0).toUpperCase()
                        }}{{ loan.borrower?.last_name.charAt(0).toUpperCase() }}
                      </div>
                      <!--show profile path-->
                      <div
                        v-else
                        class="relative rounded-full w-10 h-10 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 outline-none overflow-hidden"
                      >
                        <img
                          :src="fullUrl(loan.borrower?.profile_picture)"
                          alt="Profile"
                          class="object-cover w-full h-full rounded-full"
                        />
                      </div>

                      <div class="min-w-0 flex-1">
                        <div>
                          <p
                            class="font-semibold text-gray-900 text-lg sm:text-xl truncate"
                          >
                            {{ loan.borrower?.first_name }}
                            {{ loan.borrower?.last_name }}
                          </p>
                        </div>

                        <div
                          class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mt-1"
                        >
                          <p class="text-green-600 text-sm font-medium">
                            {{ loan.borrower?.credit_score }}
                          </p>
                          <span
                            :class="[
                              'px-2 py-1 rounded-full text-xs font-medium',
                              loan.riskLevel === 'Low'
                                ? 'bg-green-100 text-green-800'
                                : loan.riskLevel === 'Medium'
                                ? 'bg-yellow-100 text-yellow-800'
                                : 'bg-red-100 text-red-800',
                            ]"
                          >
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Loan Details -->
                    <div class="w-full lg:w-auto">
                      <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                          <p class="text-gray-500 text-xs sm:text-sm mb-1">
                            Amount
                          </p>
                          <p
                            class="text-gray-900 font-semibold text-lg sm:text-xl"
                          >
                            ${{ loan.request_amount }}
                          </p>
                        </div>

                        <div>
                          <p class="text-gray-500 text-xs sm:text-sm mb-1">
                            Interest Rate
                          </p>
                          <p
                            class="text-gray-900 font-semibold text-lg sm:text-xl"
                          >
                            {{ loan.interest_rate }}%
                          </p>
                        </div>

                        <div>
                          <p class="text-gray-500 text-xs sm:text-sm mb-1">
                            Term
                          </p>
                          <p
                            class="text-gray-900 font-semibold text-lg sm:text-xl"
                          >
                            {{ loan.request_duration }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Loan Purpose and Actions -->
                  <div class="mt-6 pt-6 border-t border-gray-200">
                    <div
                      class="flex flex-col lg:flex-row justify-start items-start lg:items-end gap-4"
                    >
                      <div class="flex-1 min-w-0">
                        <p
                          class="text-gray-700 text-base sm:text-lg font-medium mb-2"
                        >
                          Reason for loan:
                        </p>
                        <p class="text-sm text-gray-600 leading-relaxed">
                          {{ loan.request_reason }}
                        </p>
                      </div>
                      <div>
                        <NuxtLink
                          :to="`/userUI/lender/loanPreview/${loan.id}`"
                          class="py-2 px-5 bg-blue-400 hover:bg-blue-500 text-white rounded-lg"
                          >View detail</NuxtLink
                        >
                      </div>
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
          <!-- <div v-if="loans.length === 0" class="text-center py-12">
                        <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Opportunities Available</h3>
                        <p class="text-gray-500">Check back later for new investment opportunities.</p>
                        </div> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
definePageMeta({
  layout: "lender",
  middleware: "authlender",
});

import search from "~/components/icons/search.vue";
import x from "~/components/icons/x-sign.vue";
import chevronDown from "~/components/icons/chevron-down.vue";
import { useAuth } from "~/composables/useAuth";
import { useRuntimeConfig } from "#app";
import { ref, onMounted, computed } from "vue";

const token = useAuth();
const config = useRuntimeConfig();

const loans = ref();
const loading = ref(true);
const fullUrl = (path) => `http://localhost:8001${path}`;
onMounted(async () => {
  try {
    const res = await $fetch(`${config.public.apiBase}/getAllLoan`, {
      headers: {
        Authorization: `Bearer ${token.value}`,
      },
    });

    if (res) {
      loans.value = res.loan;
      // alert(res.message)
    }
  } catch (error) {
    console.error("Failed to fetch loans:", error);
  } finally {
    loading.value = false;
  }
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

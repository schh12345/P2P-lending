<template>
  <div class="p-4 md:p-8">
    <div class="w-full mx-auto md:flex md:justify-between gap-6 mb-8">
      <div class="p-6 space-y-6 w-full">
        <div class="rounded-lg shadow-md p-7 bg-white">
          <h2 class="text-xl font-semibold">Previous Loan Requests</h2>
        </div>

        <div v-if="loading" class="text-center text-gray-600 text-lg py-10">
          Loading loans...
        </div>

        <div v-else>
          <div
            v-if="loans.length === 0"
            class="text-center text-gray-500 text-xl py-10"
          >
            No loan records found.
          </div>

          <div v-else class="space-y-10">
            <div
              v-for="loan in loans"
              :key="loan.request_id"
              class="bg-white p-4 sm:p-6 rounded-lg shadow-sm"
            >
              <div
                class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6"
              >
                <!-- status -->
                <div class="flex justify-between items-center mb-2">
                  <span
                    class="text-sm font-semibold px-3 py-1 rounded-full"
                    :class="{
                      'bg-yellow-200 text-yellow-800':
                        loan.status === 'Pending',
                      'bg-green-200 text-green-800': loan.status === 'Approved',
                      'bg-red-200 text-red-800': loan.status === 'Rejected',
                      // 'bg-gray-200 text-gray-800': loan.status === 'completed'
                    }"
                  >
                    {{ loan.status }}
                  </span>
                </div>

                <!-- Loan Details -->
                <div class="w-full lg:w-auto">
                  <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                      <p class="text-gray-500 text-xs sm:text-sm mb-1">
                        Amount
                      </p>
                      <p class="text-gray-900 font-semibold text-lg sm:text-xl">
                        ${{ loan.request_amount }}
                      </p>
                    </div>

                    <div>
                      <p class="text-gray-500 text-xs sm:text-sm mb-1">
                        Interest Rate
                      </p>
                      <p class="text-gray-900 font-semibold text-lg sm:text-xl">
                        {{ loan.interest_rate }}%
                      </p>
                    </div>

                    <div>
                      <p class="text-gray-500 text-xs sm:text-sm mb-1">Term</p>
                      <p class="text-gray-900 font-semibold text-lg sm:text-xl">
                        {{ loan.request_duration }}
                      </p>
                    </div>
                  </div>
                </div>

                <!-- Actions -->
                <!-- <div class="flex justify-between items-center mt-5">
                                <NuxtLink
                                :to="`/userUI/borrower/editLoanRequest/${loan.request_id}`"
                                class="text-sm bg-blue-500 text-white px-4 py-2 rounded-xl hover:bg-blue-600 transition"
                                >
                                Edit
                                </NuxtLink>
                                <NuxtLink
                                :to="`/userUI/borrower/delete/${loan.request_id}`"
                                class="text-sm bg-red-500 text-white px-4 py-2 rounded-xl hover:bg-red-600 transition"
                                >
                                Delete
                                </NuxtLink>
                            </div> -->

                <!-- Optional Files -->
                <!-- <div class="mt-4">
                                <p class="text-xs text-gray-400 truncate">{{ loan.employment_path }}</p>

                                <img
                                v-if="loan.identity_path"
                                :src="fullUrl(loan.identity_path)"
                                alt="Identity Image"
                                class="mt-2 w-full h-199 object-cover rounded-lg border border-gray-300"
                                />
                            </div> -->
              </div>

              <!-- Loan Purpose and Actions -->
              <div class="mt-4 pt-6 border-t border-gray-200">
                <div
                  class="flex flex-col lg:flex-row justify-start items-start lg:items-end gap-4"
                >
                  <div class="flex-1 min-w-0">
                    <p class="ext-gray-500 text-xs sm:text-sm mb-1">
                      Reason for loan:
                    </p>
                    <p class="text-gray-900 font-semibold text-lg sm:text-xl">
                      {{ loan.request_reason }}
                    </p>
                  </div>
                  <div>
                    <NuxtLink
                      :to="`/userUI/borrower/LoanRequestCheckingReview/${loan.request_id}`"
                      class="text-sm bg-gray-700 text-white px-8 py-3 rounded-xl hover:bg-gray-800 transition"
                    >
                      view detail
                    </NuxtLink>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import { useAuth } from "~/composables/useAuth";
import { useRuntimeConfig } from "#app";
import { borrowerProfileData } from "~/composables/borrowerProfileData";

definePageMeta({
  layout: "borrower",
  middleware: "auth",
});

// Runtime and token
const token = useAuth();
const config = useRuntimeConfig();
const { id } = await borrowerProfileData();

// interface Loan {
// request_id: number
// request_amount: number
// request_duration: number
// request_reason:string
// interest_rate:number
// employment_status:string
// income:number
// identity_path:string
// employment_path:string
// status: string

// add other properties if needed
//}

const fullUrl = (path) => `http://localhost:8001${path}`;
const loans = ref([]);
const loading = ref(true);
onMounted(async () => {
  try {
    const loanRes = await $fetch(`${config.public.apiBase}/allLoan/${id}`, {
      headers: {
        Authorization: `Bearer ${token.value}`,
      },
    });
    loans.value = loanRes.loans;
  } catch (error) {
    console.error("Failed to fetch loans:", error);
  } finally {
    loading.value = false;
  }
});
</script>

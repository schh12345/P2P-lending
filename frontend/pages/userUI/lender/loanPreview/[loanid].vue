<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div v-if="loading">loading loan information</div>
    <div v-else>
      <div v-if="loans" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Left Sidebar -->
        <aside class="space-y-6">
          <!-- User Profile -->
          <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow p-6">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">
              User Profile
            </h4>
            <div class="flex items-center space-x-3">
              <!--show the initail word of firstname & lastname of borrower if profile_path did not upload-->
              <div
                v-if="!loans.borrower?.profile_picture"
                :class="[
                  'flex-shrink-0 flex items-center justify-center rounded-full w-12 h-12 text-white font-bold text-lg',
                  getRandomBg(loans.borrower?.first_name),
                ]"
              >
                {{ loans.borrower?.first_name.charAt(0).toUpperCase()
                }}{{ loans.borrower?.last_name.charAt(0).toUpperCase() }}
              </div>
              <!--show profile path-->
              <div
                v-else
                class="relative rounded-full w-10 h-10 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 outline-none overflow-hidden"
              >
                <img
                  :src="fullUrl(loans.borrower?.profile_picture)"
                  alt="Profile"
                  class="object-cover w-full h-full rounded-full"
                />
              </div>
              <span class="text-lg font-medium text-gray-900"
                >{{ loans.borrower?.first_name }}
                {{ loans.borrower?.last_name }}</span
              >
            </div>

            <div class="mt-6 space-y-3 text-sm">
              <div class="flex justify-between text-gray-700">
                <span>Credit Score</span>
                <span class="text-green-600 font-semibold">{{
                  loans.borrower?.credit_score
                }}</span>
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
            <h5 class="text-lg font-semibold text-gray-800 mb-4">
              Credit Records
            </h5>
            <div v-if="loading1" class="text-center text-gray-500">
              Loading...
            </div>
            <div v-else>
              <div
                v-if="creditRecords"
                class="bg-gray-50 rounded-lg p-4 space-y-1 text-sm text-gray-700"
              >
                <div
                  v-for="creditRecord in creditRecords"
                  :key="creditRecord.id"
                  class="text-md mb-5"
                >
                  <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm">
                    <div class="border-b-1 border-gray-3">
                      <div class="mb-5 flex justify-between items-center">
                        <p>status</p>
                        <p
                          :class="[
                            'px-3 py-2 rounded-md text-xs font-semibold',
                            creditRecord.status === 'Active'
                              ? 'bg-green-100 text-green-800'
                              : creditRecord.status === 'Completed'
                              ? 'bg-blue-100 text-blue-800'
                              : 'bg-red-100 text-red-800',
                          ]"
                        >
                          <strong>{{ creditRecord.status }}</strong>
                        </p>
                      </div>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                      <p class="">Amount</p>
                      <p>
                        <strong>${{ creditRecord.amount }}</strong>
                      </p>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                      <p class="">Duration</p>
                      <p>
                        <strong>{{ creditRecord.duration }}Days</strong>
                      </p>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                      <p class="">Interest Rate</p>
                      <p>
                        <strong>{{ creditRecord.interest_rate }}%</strong>
                      </p>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                      <p class="">Total</p>
                      <p>
                        <strong>${{ creditRecord.total }}</strong>
                      </p>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                      <p class="">Start Date</p>
                      <p>
                        <strong>${{ creditRecord.start_date }}</strong>
                      </p>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                      <p class="">Due Date</p>
                      <p>
                        <strong>${{ creditRecord.payment_date }}</strong>
                      </p>
                    </div>
                    <div
                      v-if="creditRecord.lateDay"
                      class="flex justify-between items-center mt-2"
                    >
                      <p>Was Late:</p>
                      <span class="text-red-600"
                        ><strong>{{ creditRecord.lateDay }}Days</strong></span
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </aside>

        <!-- Right Content -->
        <section class="md:col-span-1 space-y-8">
          <!-- Loan Details -->
          <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Loan Details</h3>

            <div class="space-y-4 mb-5">
              <div>
                <p class="text-gray-600 text-sm">Requested Amount</p>
                <p class="text-3xl font-extrabold text-gray-900">
                  {{ loans.request_amount }}
                </p>
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
            <h3 class="text-2xl font-bold text-gray-800 mb-6">
              Submitted Document
            </h3>
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
              <p class="text-base font-medium text-gray-800">
                Employment Document
              </p>
              <div class="bg-gray-200 p-4 rounded-lg">
                <div
                  class="bg-white rounded-xl p-4 flex justify-between items-center transition"
                >
                  <div>
                    <img
                      :src="`http://localhost:8001${loans.borrower?.employment_path}`"
                      class="w-full h-[200px]"
                      alternative="identity"
                    />
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
                class="py-3 md:py-3 lg:px-20 lg:py-3 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg transition-colors duration-200 text-center block w-full sm:w-auto"
              >
                Approve
              </NuxtLink>

              <NuxtLink
                to="/userUI/lender/marketplace"
                class="py-3 md:py-3 lg:px-20 lg:py-3 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg transition-colors duration-200 text-center block w-full sm:w-auto"
              >
                Cancel
              </NuxtLink>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuth } from "~/composables/useAuth";
import { useRuntimeConfig, useRoute } from "#app";
import { ref, onMounted, computed } from "vue";

definePageMeta({
  layout: "lender",
  middleware: "authlender",
});
const route = useRoute();
const token = useAuth();
const config = useRuntimeConfig();

const loans = ref();
const loading = ref(true);
const creditRecords = ref([]);
const loading1 = ref(true);
const fullUrl = (path) => `http://localhost:8001${path}`;
const id = ref();
onMounted(async () => {
  try {
    const res = await $fetch(
      `${config.public.apiBase}/getLoan/${route.params.loanId}`,
      {
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      }
    );

    if (res) {
      loans.value = res.loan;
      id.value = loans.value?.borrower?.id;
      console.log(id.value);
    }
  } catch (error) {
    console.error("Failed to fetch loans:", error);
  } finally {
    loading.value = false;
  }

  // fetch credit record of borrower
  try {
    const res1 = await $fetch(
      `${config.public.sanctum.baseUrl}/getAllLoanAfterApproveforBorrower/${id.value}`,
      {
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      }
    );
    if (res1 && res1.loan) {
      creditRecords.value = res1.loan;
    }
  } catch (error) {
    console.error("Failed to fetch loans:", error);
  } finally {
    loading1.value = false;
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

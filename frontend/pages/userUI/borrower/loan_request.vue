<template>
  <div class="p-4 md:p-8">
    <div class="max-w-6xl mx-auto md:flex md:justify-between gap-6 mb-8">
      <form @submit.prevent="handleRequest" class="w-full">
        <!-- Loan Details Form -->

        <!--fill the loan request form-->
        <div class="bg-white rounded-2xl p-6 shadow space-y-4">
          <div class="border-b-1 border-gray-300 mb-8">
            <h2 class="text-xl font-semibold mb-2">Loan Details</h2>

            <div>
              <!--loan amount-->
              <label class="block text-sm font-medium">Loan Amount*</label>
              <div
                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600"
              >
                <div
                  class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6"
                >
                  $
                </div>
                <input
                  type="number"
                  v-model="form.amount"
                  min="100"
                  max="10000"
                  class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                  placeholder="0.00"
                />
              </div>
              <p v-if="errors.amount" class="text-red-500 text-sm mt-1">
                {{ errors.amount }}
              </p>
            </div>

            <!--lona interest rate-->
            <div>
              <label class="block text-sm font-medium"
                >Proposed Interest Rate*</label
              >
              <div
                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600"
              >
                <div
                  class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6"
                >
                  %
                </div>
                <div
                  class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                >
                  {{ interest_rate }}
                </div>
              </div>
              <p class="text-xs text-gray-400">
                Interest rate set auto by our system and base on your credit
                score
              </p>
            </div>

            <!--loan duration-->
            <div>
              <label class="block text-sm font-medium">Loan Duration*</label>
              <div
                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600"
              >
                <input
                  type="number"
                  v-model="form.duration"
                  class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                  placeholder="0.00"
                />
                <div
                  class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6 px-3"
                >
                  |
                </div>
                <div
                  class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6 pr-3"
                >
                  days
                </div>
              </div>
              <p v-if="errors.duration" class="text-red-500 text-sm mt-1">
                {{ errors.duration }}
              </p>
            </div>
            <!--loan reason-->
            <div>
              <label class="block text-sm font-medium">Reason for Loan*</label>
              <input
                type="text"
                v-model="form.reason"
                placeholder="Home Improvement"
                class="mt-1 w-full rounded-md border border-gray-300 px-4 py-2"
              />
              <p v-if="errors.reason" class="text-red-500 text-sm mt-1">
                {{ errors.reason }}
              </p>
            </div>
          </div>

          <!-- Preview Section -->
          <div class="mt-6 bg-white p-6 shadow rounded-2xl space-y-4">
            <h3 class="font-bold text-lg text-gray-800 mb-2 text-center">
              Preview Loan Requesting
            </h3>
            <div class="space-y-1 text-sm border-b-1 border-gray-200">
              <div class="md:flex md:justify-between">
                <p><strong>Loan Amount:</strong></p>
                <p>${{ form.amount }}</p>
              </div>
              <div class="md:flex md:justify-between">
                <p><strong>Interest rate:</strong></p>
                <p>{{ interest_rate }}%</p>
              </div>
              <div class="md:flex md:justify-between">
                <p><strong>duration:</strong></p>
                <p>{{ form.duration }} days</p>
              </div>
              <div class="md:flex md:justify-between mb-5">
                <p><strong>Reason:</strong></p>
                <p>{{ form.reason }}</p>
              </div>
            </div>
            <div class="mt-5">
              <div class="md:flex md:justify-between">
                <p><strong>Amount For Return:</strong></p>
                <p>${{ total }}</p>
              </div>
            </div>

            <!--button submit-->
            <div
              class="w-full mt-10 py-3 bg-blue-500 rounded-lg text-normal text-center text-white"
            >
              <button type="submit" class="w-full">Save</button>
            </div>
          </div>
        </div>
      </form>
      <!--upload document-->
    </div>

    <!-- Previous Loan Requests -->
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from "vue";
import { useAuth } from "~/composables/useAuth";
import { useRuntimeConfig } from "#app";
import { borrowerProfileData } from "@/composables/borrowerProfileData";
// Runtime and token
const token = useAuth();
const config = useRuntimeConfig();
const { id, credit_score } = await borrowerProfileData();
const borrowerId = ref(id);
// Page meta
definePageMeta({
  layout: "borrower",
  middleware: "auth",
});

// Form state (Don't use ref inside reactive for file — keep it separate)
const form = reactive({
  amount: "",
  duration: "",
  reason: "",
});

// Error state
const errors = reactive({
  amount: "",
  duration: "",
  reason: "",
});

// Auto set interest rate on mount
const interest_rate = ref(0);
onMounted(() => {
  if (typeof credit_score !== "undefined" && credit_score >= 70) {
    interest_rate.value = 5;
  } else if (typeof credit_score !== "undefined" && credit_score < 70) {
    interest_rate.value = 6.5;
  }
});

const total = computed(() => {
  if (!form.amount || !interest_rate.value || !form.duration) return 0;

  return (
    Number(form.amount) *
    (1 + (interest_rate.value / 100) * (Number(form.duration) / 30))
  ).toFixed(2);
});

// Submit handler
const handleRequest = async () => {
  // Reset all errors
  Object.assign(errors, {
    amount: "",
    duration: "",
    reason: "",
    emp_status: "",
    income: "",
    imageFile: "",
    imageFileEmp: "",
  });

  let valid = true;

  if (!form.amount) {
    errors.amount = "Amount is required";
    valid = false;
  } else if (+form.amount < 100 || +form.amount > 10000) {
    errors.amount = "Amount must be between 100 to 10000";
    valid = false;
  }

  if (!form.duration) {
    errors.duration = "Duration is required";
    valid = false;
  } else if (+form.duration > 180) {
    errors.duration = "Duration must be under 180 day";
    valid = false;
  }

  if (!form.reason) {
    errors.reason = "Reason is required";
    valid = false;
  }

  if (!valid) return;

  console.log("Form data being sent:", {
    request_amount: form.amount,
    request_duration: form.duration,
    request_reason: form.reason,
    request_borrowerID: borrowerId.value,
  });
  console.log(id);
  console.log("borrowerId.value:", borrowerId.value);
  console.log("token.value:", token.value);
  try {
    await $fetch(`${config.public.apiBase}/loanRequest`, {
      method: "POST",
      body: {
        request_amount: form.amount,
        request_duration: form.duration,
        // interest_rate: interest_rate.value,
        request_reason: form.reason,
        total: total.value,
        request_borrowerID: id,
      },
      headers: {
        Authorization: `Bearer ${token.value}`,
      },
    });

    alert("Loan request successful");
  } catch (error: any) {
    console.error("Update failed:", error);
    alert("Update failed: " + (error.data?.message || error.message));
  }

  // Optional: show validation messages from Laravel
};

interface Loan {
  request_id: number;
  request_amount: number;
  request_duration: number;
  request_reason: string;
  interest_rate: number;
  employment_status: string;
  income: number;
  identity_path: string;
  employment_path: string;
  status: string;

  // add other properties if needed
}
</script>

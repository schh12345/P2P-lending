<template>
  <div class="p-4 md:p-8">
    <!-- Back Button -->
    <div class="bg-white p-4 rounded-lg shadow w-fit mb-10">
      <NuxtLink
        to="/userUI/borrower/LoanRequestChecking"
        class="inline-flex items-center text-teal-700 hover:text-teal-900 font-medium"
      >
        ← Back to Loan Request checking
      </NuxtLink>
    </div>

    <div class="max-w-6xl mx-auto md:flex md:justify-between gap-6 mb-8">
      <div class="w-full">
        <!-- Loan Details Form -->

        <!--fill the loan request form-->
        <div class="bg-white rounded-2xl p-6 shadow space-y-4">
          <div class="border-b-1 border-gray-300 mb-8">
            <h2 class="text-xl font-semibold mb-2">Loan Details</h2>
          </div>

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
              <div
                class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
              >
                {{ loans.request_amount }}
              </div>
            </div>
            <!-- <p v-if="errors.amount" class="text-red-500 text-sm mt-1">{{ errors.amount }}</p> -->
          </div>

          <!--lona interest rate-->
          <div>
            <label class="block text-sm font-medium">Interest rate</label>
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
                {{ loans.interest_rate }}
              </div>
            </div>
            <!-- <p class="text-xs text-gray-400 ">Interest rate set auto by our system and base on your credit score</p> -->
          </div>

          <!--loan duration-->
          <div>
            <label class="block text-sm font-medium">Loan Duration</label>
            <div
              class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600"
            >
              <div
                class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
              >
                {{ loans.request_duration }}
              </div>
              <div
                class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6 px-3"
              >
                |
              </div>
              <div
                class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6 pr-3"
              >
                months
              </div>
            </div>
            <p v-if="errors.duration" class="text-red-500 text-sm mt-1">
              {{ errors.duration }}
            </p>
          </div>
          <!--loan reason-->
          <div>
            <label class="block text-sm font-medium">Reason for Loan</label>
            <div
              class="mt-1 w-full rounded-md border border-gray-300 px-4 py-2"
            >
              {{ loans.request_reason }}
            </div>
            <!-- <p v-if="errors.reason" class="text-red-500 text-sm mt-1">{{ errors.reason }}</p> -->
          </div>
        </div>

        <!-- Preview Section -->
        <div class="mt-6 bg-white p-6 shadow rounded-2xl space-y-4">
          <h3 class="font-bold text-lg text-gray-800 mb-2 text-center">
            Preview Loan Requesting
          </h3>
          <div
            class="space-y-3 text-lg border-b-1 border-gray-200 text-gray-900"
          >
            <div class="md:flex md:justify-between">
              <p><strong>Loan Amount:</strong></p>
              <p>{{ loans.request_amount }}</p>
            </div>
            <div class="md:flex md:justify-between">
              <p><strong>Interest rate:</strong></p>
              <p>{{ loans.interest_rate }}%</p>
            </div>
            <div class="md:flex md:justify-between">
              <p><strong>duration:</strong></p>
              <p>{{ loans.request_duration }} months</p>
            </div>
            <div class="md:flex md:justify-between mb-5">
              <p><strong>Reason:</strong></p>
              <p>car repair</p>
            </div>
          </div>
          <div class="mt-5">
            <div class="md:flex md:justify-between text-lg text-gray-800">
              <p><strong>Amount For Return:</strong></p>
              <p>{{ total }}</p>
            </div>
          </div>
        </div>

        <!--upload document-->
        <div class="mt-6 bg-white p-6 shadow rounded-2xl space-y-4">
          <div class="border-b-1 border-gray-300 mb-8">
            <h2 class="text-xl font-semibold mb-2">Financial</h2>
          </div>
          <div class="space-y-5 text-sm">
            <!--employment status-->
            <div class="space-y-1">
              <label class="block text-sm font-medium">Employment Status</label>
              <select
                v-model="form.emp_status"
                class="w-full rounded-md bg-white p-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600"
              >
                <option value="">Select your employment status</option>
                <option value="full-time">Full time</option>
                <option value="part-time">Part time</option>
                <option value="full_time">Freelancer</option>
              </select>
              <p v-if="errors.emp_status" class="text-red-500 text-sm mt-1">
                {{ errors.emp_status }}
              </p>
            </div>

            <!--monthly income-->
            <div class="space-y-1">
              <label class="block text-sm font-medium">Monthly Income</label>
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
                  v-model="form.income"
                  min="100"
                  max="5000"
                  class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                  placeholder="0.00"
                />
              </div>
              <p v-if="errors.income" class="text-red-500 text-sm mt-1">
                {{ errors.income }}
              </p>
            </div>

            <!--upload documnet section-->
            <div class="space-y-5">
              <!--upload national identity-->
              <div class="space-y-1">
                <!-- Upload Input -->
                <label class="block text-sm font-medium">
                  National Identity
                </label>

                <!-- Image preview -->
                <div v-if="imagePreview" class="mt-4">
                  <p class="text-sm text-gray-500 mb-2">Click to enlarge:</p>
                  <img
                    :src="imagePreview"
                    alt="Preview"
                    @click="openModal"
                    class="rounded-lg shadow w-full max-h-64 object-contain cursor-pointer hover:opacity-80 transition"
                  />
                </div>

                <!-- Fullscreen Modal -->
                <div
                  v-if="isModalOpen"
                  class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center"
                  @click.self="closeModal"
                >
                  <img
                    :src="imagePreview"
                    alt="Full View"
                    class="max-w-full max-h-full rounded shadow-xl"
                  />
                  <button
                    @click="closeModal"
                    class="absolute top-4 right-4 text-white text-2xl bg-gray-700/70 p-2 rounded-full hover:bg-gray-600"
                  >
                    &times;
                  </button>
                </div>
              </div>

              <!--upload employee document-->
              <div class="space-y-1">
                <!-- Upload Input -->
                <label class="block text-sm font-medium">
                  Employee Document
                </label>

                <!-- Image preview -->
                <div v-if="imagePreviewEmp" class="mt-4">
                  <p class="text-sm text-gray-500 mb-2">Click to enlarge:</p>
                  <img
                    v-if="imagePreviewEmp"
                    :src="imagePreviewEmp"
                    alt="Preview"
                    @click="openModalEmp"
                    class="rounded-lg shadow w-full max-h-64 object-contain cursor-pointer hover:opacity-80 transition"
                  />
                </div>

                <!-- Fullscreen Modal -->
                <div
                  v-if="isModalOpenEmp"
                  class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center"
                  @click.self="closeModalEmp"
                >
                  <img
                    :src="imagePreviewEmp"
                    alt="Full View"
                    class="max-w-full max-h-full rounded shadow-xl"
                  />
                  <button
                    @click="closeModalEmp"
                    class="absolute top-4 right-4 text-white text-2xl bg-gray-700/70 p-2 rounded-full hover:bg-gray-600"
                  >
                    &times;
                  </button>
                </div>
              </div>

              <!--button submit-->
              <!-- <div class="w-full mt-10 py-3 bg-blue-500 rounded-lg text-normal text-center text-white ">
                      <button type="submit" class="w-full">Save</button>
                    </div> -->
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
import { useRuntimeConfig, useRouter } from "#app";
import { useRoute } from "vue-router";
import { borrowerProfileData } from "~/composables/borrowerProfileData";

const token = useAuth();
const config = useRuntimeConfig();
const router = useRouter();
const route = useRoute();
const { id } = await borrowerProfileData();
const borrowerId = ref(id);

// Meta
definePageMeta({
  layout: "borrower",
  middleware: "auth",
});

// Form state
const form = reactive({
  amount: "",
  duration: "",
  reason: "",
  emp_status: "",
  income: "",
});
const interest_rate = ref(5);
const errors = reactive({
  amount: "",
  duration: "",
  reason: "",
  emp_status: "",
  income: "",
  imageFile: "",
  imageFileEmp: "",
});

// Loan data
const loans = ref({});

const fullUrl = (path) => `http://localhost:8001${path}`;

// File uploads
const imageFile = ref();
const imageFileEmp = ref();
const identity_path = ref("");
const employment_path = ref("");
const imagePreview = ref("");
const imagePreviewEmp = ref("");
const fileName = ref("");
const fileNameEmp = ref("");

// Modals
const isModalOpen = ref(false);
const isModalOpenEmp = ref(false);

const openModal = () => (isModalOpen.value = true);
const closeModal = () => (isModalOpen.value = false);
const openModalEmp = () => (isModalOpenEmp.value = true);
const closeModalEmp = () => (isModalOpenEmp.value = false);

// Load loan data
onMounted(async () => {
  try {
    const loanId = route.params.id;
    const res = await $fetch(`${config.public.apiBase}/loan/${loanId}`, {
      headers: { Authorization: `Bearer ${token.value}` },
    });

    loans.value = res.loan;
    form.amount = res.loan.request_amount;
    form.duration = res.loan.request_duration;
    form.reason = res.loan.request_reason;
    form.income = res.borrower.income;
    form.emp_status = res.borrower.employment_status;
    interest_rate.value = res.loan.interest_rate;

    identity_path.value = res.borrower.identity_path;
    employment_path.value = res.borrower.employment_path;

    imagePreview.value = fullUrl(identity_path.value);
    fileName.value = identity_path.value.split("/").pop();

    imagePreviewEmp.value = fullUrl(employment_path.value);
    fileNameEmp.value = employment_path.value.split("/").pop();
  } catch (err) {
    console.error("Failed to load loan:", err);
  }
});
const total = computed(() => {
  const loan = loans.value;
  if (!loan.request_amount || !loan.interest_rate || !loan.request_duration)
    return 0;

  return (
    loans.value.request_amount *
    (1 +
      (loans.value.interest_rate / 100) * (loans.value.request_duration / 30))
  ).toFixed(2);
});

// Submit form
const handleRequest = async () => {
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
  } else if (form.amount < 100 || form.amount > 5000) {
    errors.amount = "Amount must be between 100 to 5000";
    valid = false;
  }

  if (!form.duration) {
    errors.duration = "Duration is required";
    valid = false;
  } else if (form.duration > 6) {
    errors.duration = "Duration must be 6 months or less";
    valid = false;
  }

  if (!form.reason) {
    errors.reason = "Reason is required";
    valid = false;
  }
  if (!form.emp_status) {
    errors.emp_status = "Employment status is required";
    valid = false;
  }
  if (!form.income) {
    errors.income = "Income is required";
    valid = false;
  }

  if (!valid) return;

  try {
    // Upload files if changed
    if (imageFile.value || imageFileEmp.value) {
      const formData = new FormData();
      if (imageFile.value) formData.append("identity", imageFile.value);
      if (imageFileEmp.value) formData.append("employment", imageFileEmp.value);

      const uploadRes = await $fetch(`${config.public.apiBase}/storeImage`, {
        method: "POST",
        body: formData,
        headers: { Authorization: `Bearer ${token.value}` },
      });

      if (uploadRes.identity_path)
        identity_path.value = uploadRes.identity_path;
      if (uploadRes.employment_path)
        employment_path.value = uploadRes.employment_path;
    }

    // Final update
    const updateRes = await $fetch(
      `${config.public.apiBase}/loanUpdate/${route.params.id}`,
      {
        method: "POST",
        body: {
          request_amount: form.amount,
          request_duration: form.duration,
          interest_rate: interest_rate.value,
          request_reason: form.reason,
          request_income: form.income,
          request_emp_status: form.emp_status,
          request_identity_path: identity_path.value,
          request_employment_path: employment_path.value,
          request_borrowerID: borrowerId.value,
        },
        headers: {
          Authorization: `Bearer ${token.value}`,
          "Content-Type": "application/json", // ✅ CRITICAL
        },
      }
    );

    if (updateRes.msg) {
      alert(updateRes.msg);
      router.push("/userUI/borrower/LoanRequestChecking");
    }
  } catch (error) {
    console.error("Update failed:", error);
    alert("Update failed: " + (error.data?.message || error.message));
  }
};
</script>

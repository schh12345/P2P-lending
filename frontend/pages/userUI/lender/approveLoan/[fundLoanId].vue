<template>
  <div class="max-w-7xl mx-auto m-10 px-4 sm:px-6 lg:px-8 py-12">
    <div v-if="loading">Loanding</div>
    <div v-else>
      <div v-if="loans" class="w-full bg-white rounded-lg p-10 space-y-4">
        <!--user profile-->
        <div class="space-y-4">
          <div class="flex justify-start items-center gap-x-5">
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

          <!--border bottom-->
          <div class="border-1 border-gray-200"></div>
        </div>

        <!--request amount-->
        <div class="flex flex-col">
          <p class="text-gray-600 text-md">Requested Amount</p>
          <p class="text-3xl font-bold text-gray-900">
            {{ loans.request_amount }}
          </p>
        </div>

        <!--payment amount-->
        <form @submit.prevent="handleFund" class="space-y-10">
          <div class="flex flex-col space-y-2">
            <label for="amount" class="text-gray-600 text-md"
              >Payment Amount *</label
            >
            <div>
              <div
                class="flex items-center rounded-md bg-gray-100 h-10 pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600"
              >
                <div
                  class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6"
                >
                  $
                </div>
                <input
                  type="number"
                  v-model="form.total"
                  class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                  placeholder="0.00"
                />
              </div>
            </div>
          </div>

          <!--fund or cancel-->
          <div class="w-full">
            <div class="flex justify-end space-x-4">
              <NuxtLink
                :to="`/userUI/lender/loanPreview/${loans.id}`"
                class="px-6 py-3 md:px-10 md:py-3 lg:px-20 lg:py-3 bg-gray-300 hover:bg-gray-400 text-gray-900 font-semibold rounded-lg transition-colors duration-200 text-center"
              >
                Cancel
              </NuxtLink>
              <button
                type="submit"
                class="px-6 py-3 md:px-10 md:py-3 lg:px-20 lg:py-3 bg-[#10B981] hover:bg-green-500 text-white font-semibold rounded-lg transition-colors duration-200 text-center"
              >
                Fund
              </button>
            </div>
          </div>
        </form>

        <!---->
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRuntimeConfig, useRouter, useRoute } from "#app";
import { useAuthLender } from "~/composables/useAuthLender";
import { lenderProfileData } from "~/composables/lenderProfileData";

definePageMeta({
  layout: "lender",
  middleware: "authlender",
});

const token = useAuthLender();
const config = useRuntimeConfig();
const router = useRouter();
const route = useRoute();
const { id } = await lenderProfileData();

const loading = ref(true);
const loans = ref();

const form = ref({
  total: 0,
});
const error = ref({
  total: "",
});
onMounted(async () => {
  try {
    const res = await $fetch(
      `${config.public.apiBase}/getLoan/${route.params.fundLoanId}`,
      {
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      }
    );

    if (res) {
      loans.value = res.loan;
      form.value.total = Number(res.loan.request_amount);
    }
  } catch (error) {
    console.error("Failed to fetch loans:", error);
  } finally {
    loading.value = false;
  }
});

const handleFund = async () => {
  try {
    const res = await $fetch(
      `${config.public.apiBase}/fund/${route.params.fundLoanId}/${id}`,
      {
        method: "POST",
        body: {
          total: Number(form.value.total),
        },
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      }
    );
    if (res) {
      alert("fund success");
      router.push("/userUI/lender/marketplace");
    }
  } catch (error) {
    console.error("Failed to fetch loans:", error);
  }
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

<template>
  <div>
    <div class="lg:mx-10 lg:my-5 md:mt-5 sm:mt-5">
      <h2
        class="text-center lg:text-left text-2xl font-bold font-sans text-gray-900"
      >
        LoanBridge
      </h2>
    </div>
    <div class="flex justify-center">
      <div class="p-8 rounded-2xl w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center mb-4">
          Verify Your Identity
        </h2>
        <p class="text-center text-sm text-gray-500 mb-6">
          Enter the 6-digit code sent to your registered email.
        </p>
        <form @submit.prevent="verifyOTP" class="space-y-6">
          <div class="flex justify-center gap-2">
            <input
              v-for="(digit, index) in otp"
              :key="index"
              v-model="otp[index]"
              @input="moveToNext(index)"
              type="text"
              maxlength="1"
              class="w-12 h-12 text-center text-lg border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <!--resend otp-->
          <div class="flex justify-between items-center text-sm text-gray-600">
            <button
              type="button"
              @click="resendOTP"
              class="text-blue-500 hover:underline"
            >
              Resend OTP
            </button>
          </div>

          <button
            type="submit"
            class="w-full bg-gray-900 text-white py-3 rounded-xl hover:bg-gray-800 transition"
          >
            Verify
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, nextTick } from "vue";
import { useRuntimeConfig, useRouter } from "#app";
import { useAuth } from "@/composables/useAuth";

definePageMeta({
  middleware: "auth",
});
const token = useAuth();
const router = useRouter();
const config = useRuntimeConfig();
const otp = ref(Array(6).fill(""));

const moveToNext = (index: number) => {
  if (otp.value[index].length === 1 && index < 5) {
    nextTick(() => {
      const nextInput = document.querySelectorAll("input")[index + 1];
      nextInput.focus();
    });
  }
};

const verifyOTP = async () => {
  const enteredOTP = otp.value.join("");

  try {
    interface OtpResponse {
      message: string;
    }

    const res = await $fetch<OtpResponse>(
      `${config.public.apiBase}/borrower/verifyOTP`,
      {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
        body: {
          otp: enteredOTP,
        },
      }
    );
    if (res && res.approve) {
      alert(res.approve);
      alert("Thank you please wainting for approve");
      router.push("/userUI/frontpage/waiting");
    } else if (res && res.reject) {
      alert(res.reject);
    }
  } catch (err: any) {}
};

const resendOTP = () => {
  alert("OTP resent");
  // You should implement actual resend logic here
};
</script>

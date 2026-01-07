<template>
  <div class="w-full">
    <div class="lg:mx-10 lg:my-5 md:mt-5 sm:mt-5">
      <h2
        class="text-center lg:text-left text-2xl font-bold font-sans text-gray-900"
      >
        LoanBridge
      </h2>
    </div>

    <div class="mx-auto max-w-xl mt-0 p-6 rounded-2xl">
      <div>
        <h2
          class="mb-2 text-center text-3xl font-bold tracking-tight text-gray-900"
        >
          Welcome back Borrower
        </h2>
      </div>
    </div>

    <div class="mt-2 sm:mx-auto sm:w-full sm:max-w-sm">
      <form @submit.prevent="handleLogin" class="space-y-6">
        <!-- Email -->
        <div>
          <label
            for="email"
            :class="
              emailValid
                ? 'text-blue-500 mb-2 block text-sm font-medium'
                : 'text-red-600 mb-2 block text-sm font-medium'
            "
            >Email</label
          >
          <input
            type="text"
            id="email"
            v-model="form.email"
            class="block w-full shadow-sm rounded-xl bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600"
          />
          <p v-if="errors.email" class="text-red-500 text-sm mt-1">
            {{ errors.email }}
          </p>
        </div>

        <!-- Password -->
        <div>
          <label
            for="password"
            :class="
              passwordValid
                ? 'text-blue-500 mb-2 block text-sm font-medium'
                : 'text-red-600 mb-2 block text-sm font-medium'
            "
            >Password</label
          >
          <input
            type="password"
            id="password"
            v-model="form.password"
            class="block w-full rounded-xl bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600"
          />
          <p v-if="errors.password" class="text-red-500 text-sm mt-1">
            {{ errors.password }}
          </p>
        </div>

        <!-- Submit Button -->
        <div>
          <button
            type="submit"
            class="flex w-full justify-center rounded-md bg-gray-900 px-3 py-1.5 text-sm font-semibold text-white shadow hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-600"
          >
            Login
          </button>
        </div>
      </form>
      <div class="flex justify-between mx-2 my-3">
        <p>do not have account?</p>
        <NuxtLink
          to="/userUI/authentication/borrower/signUp"
          class="text-blue-500 text-sans"
          >Sign up</NuxtLink
        >
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from "vue";
import { useRuntimeConfig } from "#app";
import { useAuth } from "@/composables/useAuth";

const config = useRuntimeConfig();
const token = useAuth();

const form = reactive({
  email: "",
  password: "",
});

const errors = reactive({
  email: "",
  password: "",
});

// Reactive validity flags
let emailValid = ref(true);
let passwordValid = ref(true);

const validateEmail = (email: string) =>
  /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

const handleLogin = async () => {
  errors.email = errors.password = "";
  let valid = true;

  emailValid.value = true;
  passwordValid.value = true;

  if (!form.email) {
    errors.email = "Email is required";
    emailValid.value = false;
    valid = false;
  } else if (!validateEmail(form.email)) {
    errors.email = "Enter a valid email";
    emailValid.value = false;
    valid = false;
  }

  if (!form.password) {
    errors.password = "Password is required";
    passwordValid.value = false;
    valid = false;
  } else if (form.password.length < 8) {
    errors.password = "Password must be at least 8 characters";
    passwordValid.value = false;
    valid = false;
  }

  if (!valid) return;
  try {
    interface loginResponse {
      token: string;
      msg: string;
      user?: any;
    }

    const res = await $fetch<loginResponse>(
      `${config.public.apiBase}/borrower/login`,
      {
        method: "POST",
        body: {
          email: form.email,
          password: form.password,
        },
      }
    );
    if (res && res.token) {
      token.value = res.token;
      alert("login successfull");
      navigateTo("/userUI/borrower/dashboard");
    } else if (res && res.msg) {
      alert(res.msg);
    } else {
      alert("log in fail");
    }
  } catch (err: any) {
    console.error(err);
    alert(err?.data?.message || "login failed");
  }
};
</script>

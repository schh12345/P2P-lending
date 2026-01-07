<template>
  <div class="w-full min-h-220">
    <!--sign up successful-->
    <!-- <div v-if="flashError" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <span class="font-medium">{{ flashError }}</span> 
    </div> -->

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
          Welcome Lender
        </h2>
        <p class="text-gray-600 text-center text-md">
          Join our trust platform, start investing today
        </p>
      </div>

      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form @submit.prevent="handlesubmit" class="space-y-6">
          <!-- First Name -->
          <div>
            <label
              for="firstname"
              class="block text-sm font-medium text-gray-900"
              >First Name</label
            >
            <input
              type="text"
              id="firstname"
              v-model="form.firstname"
              class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600"
            />
            <p v-if="errors.firstname" class="text-red-500 text-sm mt-1">
              {{ errors.firstname }}
            </p>
          </div>

          <!-- Last Name -->
          <div>
            <label
              for="lastname"
              class="block text-sm font-medium text-gray-900"
              >Last Name</label
            >
            <input
              type="text"
              id="lastname"
              v-model="form.lastname"
              class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600"
            />
            <p v-if="errors.lastname" class="text-red-500 text-sm mt-1">
              {{ errors.lastname }}
            </p>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-900"
              >Email</label
            >
            <input
              type="text"
              id="email"
              v-model="form.email"
              class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600"
            />
            <p v-if="errors.email" class="text-red-500 text-sm mt-1">
              {{ errors.email }}
            </p>
          </div>

          <!-- phone number -->
          <div>
            <label
              for="phone_number"
              class="block text-sm font-medium text-gray-900"
              >Phone Number</label
            >
            <input
              type="string"
              id="phone_number"
              v-model="form.phone_number"
              class="block w-full shadow-sm rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600"
            />
            <p v-if="errors.phone_number" class="text-red-500 text-sm mt-1">
              {{ errors.phone_number }}
            </p>
          </div>

          <!-- Password -->
          <div>
            <label
              for="password"
              class="block text-sm font-medium text-gray-900"
              >Password</label
            >
            <input
              type="password"
              id="password"
              v-model="form.password"
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600"
            />
            <p v-if="errors.password" class="text-red-500 text-sm mt-1">
              {{ errors.password }}
            </p>
          </div>

          <!-- Confirm Password -->
          <div>
            <label
              for="confirmPassword"
              class="block text-sm font-medium text-gray-900"
              >Confirm Password</label
            >
            <input
              type="password"
              id="confirmPassword"
              v-model="form.confirmPassword"
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600"
            />
            <p v-if="errors.confirmPassword" class="text-red-500 text-sm mt-1">
              {{ errors.confirmPassword }}
            </p>
          </div>

          <!-- Terms Checkbox -->
          <div class="mb-6 flex items-start space-x-2">
            <input
              type="checkbox"
              id="agree"
              v-model="form.agree"
              class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
            />
            <label for="agree" class="text-sm text-gray-700">
              By signing up you agree to our
              <NuxtLink
                to="/userUI/frontpage/policy"
                class="text-blue-500 font-sans"
                >terms & conditions</NuxtLink
              >
              and
              <NuxtLink to="#" class="text-blue-500 font-sans"
                >Privacy</NuxtLink
              >
            </label>
          </div>
          <p v-if="errors.agree" class="text-red-500 text-sm mt-1">
            {{ errors.agree }}
          </p>

          <!-- Submit Button -->
          <div>
            <button
              type="submit"
              class="flex w-full justify-center rounded-md bg-gray-900 px-3 py-1.5 text-sm font-semibold text-white shadow hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-600"
            >
              Continue
            </button>
          </div>
        </form>
        <div class="flex justify-between mx-2 my-3">
          <p>Already have account?</p>
          <NuxtLink
            to="/userUI/authentication/lender/login"
            class="text-blue-500 text-sans"
            >Login</NuxtLink
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from "vue";
import { useAuthLender } from "~/composables/useAuthLender";
import { useRuntimeConfig, useRouter } from "#app";
import { useFlash } from "@/composables/useFlash";
import { useFlashError } from "~/composables/uaeFlashError";
//token
const token = useAuthLender();
const config = useRuntimeConfig();
const router = useRouter();
const { setFlash } = useFlash();
const { setError, flashError } = useFlashError();

const form = reactive({
  firstname: "",
  lastname: "",
  email: "",
  phone_number: "",
  password: "",
  confirmPassword: "",
  agree: false,
});

const errors = reactive({
  firstname: "",
  lastname: "",
  email: "",
  phone_number: "",
  password: "",
  confirmPassword: "",
  agree: "",
});

const validateEmail = (email: string) =>
  /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
const phoneRegex = (phone: string) => /^\+?[0-9]{9,15}$/.test(phone);

const handlesubmit = async () => {
  // Clear errors
  errors.firstname = "";
  errors.lastname = "";
  errors.email = "";
  errors.phone_number = "";
  errors.password = "";
  errors.confirmPassword = "";
  errors.agree = "";

  let valid = true;

  if (!form.firstname) {
    errors.firstname = "Firstname is required";
    valid = false;
  }

  if (!form.lastname) {
    errors.lastname = "Lastname is required";
    valid = false;
  }

  if (!form.email) {
    errors.email = "Email is required";
    valid = false;
  } else if (!validateEmail(form.email)) {
    errors.email = "Enter a valid email";
    valid = false;
  }

  if (!form.phone_number) {
    errors.phone_number = "phone number is required";
    valid = false;
  } else if (!phoneRegex(form.phone_number)) {
    errors.phone_number = "enter a valid phone number";
    valid = false;
  }
  if (!form.password) {
    errors.password = "Password is required";
    valid = false;
  } else if (form.password.length < 8) {
    errors.password = "Password must be at least 8 characters";
    valid = false;
  }

  if (!form.confirmPassword) {
    errors.confirmPassword = "Confirm password is required";
    valid = false;
  } else if (form.confirmPassword !== form.password) {
    errors.confirmPassword = "Passwords do not match";
    valid = false;
  }

  if (!form.agree) {
    errors.agree = "You must agree with the terms and conditions";
    valid = false;
  }

  if (!valid) return;

  try {
    interface RegisterResponse {
      token: string;
      user?: any;
    }
    const res = await $fetch<RegisterResponse>(
      `${config.public.apiBase}/lender/register`,
      {
        method: "POST",
        body: {
          first_name: form.firstname,
          last_name: form.lastname,
          email: form.email,
          phone_number: form.phone_number,
          password: form.password,
        },
      }
    );

    if (res && res.token) {
      token.value = res.token;
      alert("sign up successful");
      setFlash("sign Up success full");
      router.push("/userUI/authentication/lender/otp");
    } else {
      alert("sign up failed:no token returned");
    }
  } catch (err: any) {
    console.error(err);
    // setError(err?.data?.message || 'sign up failed')
    alert(err?.data?.message || "Sign up failed");
    // setError('This email already register')
  }

  // Optional: send form to backend here
};
</script>

<template>
  <div class="flex space-y-10 shadow-md">
    <header class="bg-gray-800 shadow-md w-full fixed insert-0 z-50">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-20">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <div class="flex justify-start gap-x-5 items-center">
            <button
              @click="toggleSidebar"
              class="rounded-full w-12 h-12 bg-blue-800 hover:bg-blue-900 focus:outline-none place-items-center"
              aria-label="Toggle sidebar"
            >
              <svg
                v-if="!showSidebar"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-6 stroke-gray-300"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3.75 9h16.5m-16.5 6.75h16.5"
                />
              </svg>
              <svg
                v-else="!showSidebar"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-6 stroke-gray-300"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3.75 9h16.5m-16.5 6.75h16.5"
                />
              </svg>
            </button>
            <img :src="logo" alt="logo" style="width: 60px; height: 60px" />
          </div>
          <!--profile dropdown-->
          <div class="relative ml-3 inline-block" ref="profileDropdownRef">
            <div class="hidden md:flex justify-center items-center space-x-3">
              <!-- Button: Show Initials if no profile_path -->
              <button
                v-if="!profile_picture"
                type="button"
                @click="profileDropdown"
                :class="[
                  'flex items-center justify-center relative rounded-full w-10 h-10 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 outline-none',
                  randomBg,
                ]"
              >
                <span class="text-white text-xl font-semibold">
                  {{ initial_first_name }}{{ initial_last_name }}
                </span>
              </button>

              <!-- Button: Show Image if profile_path exists -->
              <button
                v-else
                type="button"
                @click="profileDropdown"
                class="relative rounded-full w-10 h-10 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 outline-none overflow-hidden"
              >
                <img
                  :src="fullUrl(profile_picture)"
                  alt="Profile"
                  class="object-cover w-full h-full rounded-full"
                />
              </button>

              <!-- User Name Display -->
              <div v-if="borrower">
                <p class="text-white text-base font-medium">
                  {{ first_name }} {{ last_name }}
                </p>
              </div>
            </div>

            <!--profile dropdown-->
            <div
              v-if="profileOpen"
              class="absolute right-0 x-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 showdow-lg ring-1 right-black/5 focus:outline-hidden"
            >
              <NuxtLink
                to="/userUI/borrower/profile"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                >Profile</NuxtLink
              >
              <NuxtLink
                to="/userUI/borrower/editProfile"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                >Edit Profile</NuxtLink
              >
              <button
                @click="logout"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
              >
                SignOut
              </button>
            </div>

            <!-- Mobile Menu Button -->
            <button
              @click="isOpen = !isOpen"
              class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-100"
            >
              <svg
                v-if="!isOpen"
                class="w-6 h-6 bg-white hover:bg-gray-300"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
              </svg>
              <svg
                v-else
                class="w-6 h-6 bg-white"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
      <!-- Mobile Nav Links -->
      <div
        v-if="isOpen"
        class="md:hidden px-4 pb-4 pt-4 space-y-2 border-t border-gray-500"
      >
        <div class="flex items-center space-x-2">
          <button
            type="button"
            :class="[
              'relative rounded-full w-8 h-8 text-sm focus:ring-2 focus-ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden',
              `${randomBg}`,
            ]"
          >
            <!--show the begining letter user name-->
            <p class="text-xl text-gray-100 text-bold">
              {{ initial_first_name }}{{ initial_last_name }}
            </p>
            <!--or image if user have uploaded image-->
          </button>
          <p class="text-sm font-medium text-white">
            {{ first_name }} {{ last_name }}
          </p>
        </div>

        <NuxtLink
          to="#"
          class="block px-4 py-2 text-sm text-white hover:bg-gray-400"
          >Profile</NuxtLink
        >
        <NuxtLink
          to="#"
          class="block px-4 py-2 text-sm text-white hover:bg-gray-400"
          >Edit Profile</NuxtLink
        >
        <NuxtLink
          @click="logout"
          class="block px-4 py-2 text-sm text-white hover:bg-gray-400"
          >Sign Out</NuxtLink
        >
      </div>
    </header>
  </div>
</template>

<script setup lang="ts">
import logo from "~/assets/image/logo.png";

import { ref, onMounted, onBeforeUnmount, computed } from "vue";
import { useRuntimeConfig } from "#app";
import { useAuth } from "~/composables/useAuth";
import { borrowerCookie } from "~/composables/borrowerCookie";
import { useSideNavLender } from "~/composables/useSideNavLender";
import { borrowerProfileData } from "@/composables/borrowerProfileData";

const config = useRuntimeConfig();
const token = useAuth();

const {
  first_name,
  last_name,
  initial_first_name,
  initial_last_name,
  randomBg,
  profile_picture,
} = await borrowerProfileData();
const fullUrl = (path: string) => `http://localhost:8001${path}`;
const { borrower } = await borrowerCookie();

const profileOpen = ref(false);
const profileDropdownRef = ref<HTMLElement | null>(null);

function profileDropdown() {
  profileOpen.value = !profileOpen.value;
}

function handleClickOutside(event: MouseEvent) {
  const isClickInsideProfile = profileDropdownRef.value?.contains(
    event.target as Node
  );
  if (!isClickInsideProfile) {
    profileOpen.value = false;
  }
}
onMounted(() => {
  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});

const { toggleSidebar, showSidebar } = useSideNavLender();

const isOpen = ref(false);

//logout script
const logout = async () => {
  try {
    if (token.value) {
      await $fetch(`${config.public.apiBase}/borrower/logout`, {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      });
    }

    // Clear state
    token.value = null;
    borrower.value = null;

    // Redirect to landing page
    await navigateTo("/userUI/frontpage/");
  } catch (err) {
    alert("Logout failed");
    console.error(err);
  }
};
</script>

<template>
  <div class="min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="overflow-hidden mb-8">
        <div class="bg-white rounded-lg px-6 py-4">
          <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
            <NuxtLink
              to="/userUI/lender/editProfile"
              class="flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 backdrop-blur-sm text-gray-800 rounded-lg transition-all duration-200 hover:scale-105"
            >
              <edit class="w-4 h-4" />
              <span class="font-medium">Edit Profile</span>
            </NuxtLink>
          </div>
        </div>

        <!-- Profile Content -->
        <div class="p-6 lg:p-8">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Picture Section -->
            <div
              class="lg:col-span-1 flex flex-col items-center lg:items-start"
            >
              <div class="relative group">
                <!-- Profile Image -->
                <div
                  v-if="profile_picture"
                  @click="openModal"
                  class="w-32 h-32 lg:w-40 lg:h-40 rounded-full shadow-lg cursor-pointer overflow-hidden ring-4 ring-blue-100 hover:ring-blue-200 transition-all duration-300"
                >
                  <img
                    :src="fullUrl(profile_picture)"
                    alt="Profile Picture"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                  />
                </div>

                <!-- Initials Fallback -->
                <div
                  v-else
                  :class="`w-32 h-32 lg:w-40 lg:h-40 rounded-full ${randomBg} flex items-center justify-center text-3xl lg:text-4xl font-bold text-white shadow-lg ring-4 ring-blue-100`"
                >
                  {{ initial_first_name }}{{ initial_last_name }}
                </div>

                <!-- Online Status Indicator -->
                <div
                  class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-4 border-white"
                ></div>
              </div>

              <!-- Name and Basic Info -->
              <div class="mt-4 text-center lg:text-left">
                <h2 class="text-xl lg:text-2xl font-bold text-gray-800">
                  {{ first_name }} {{ last_name }}
                </h2>
                <p class="text-gray-600 mt-1">{{ province }}</p>
                <!-- <div class="flex items-center justify-center lg:justify-start mt-2">
                  <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Active</span>
                  </div>
                </div> -->
              </div>
            </div>

            <!-- Information Sections -->
            <div class="lg:col-span-2 space-y-8">
              <!-- Personal Information -->
              <div class="bg-gray-50 rounded-xl p-6">
                <h3
                  class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2"
                >
                  <svg
                    class="w-5 h-5 text-blue-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    ></path>
                  </svg>
                  Personal Information
                </h3>
                <div class="space-y-4">
                  <div
                    class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2"
                  >
                    <span class="text-gray-600 font-medium">Email</span>
                    <span class="text-gray-800 font-medium">{{ email }}</span>
                  </div>
                  <div
                    class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2"
                  >
                    <span class="text-gray-600 font-medium">Phone Number</span>
                    <span class="text-gray-800 font-medium">{{
                      phone_number
                    }}</span>
                  </div>
                  <div
                    class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2"
                  >
                    <span class="text-gray-600 font-medium">Location</span>
                    <span class="text-gray-800 font-medium">{{
                      province
                    }}</span>
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
import edit from "~/components/icons/edit.vue";
import { lenderProfileData } from "~/composables/lenderProfileData";
import { useAuthLender } from "~/composables/useAuthLender";

definePageMeta({
  layout: "lender",
  middleware: "authlender",
});

let {
  id,
  first_name,
  last_name,
  email,
  phone_number,
  initial_first_name,
  initial_last_name,
  randomBg,
  profile_picture,
  province,
} = await lenderProfileData();

const token = useAuthLender();
const config = useRuntimeConfig();
const fullUrl = (path) => `http://localhost:8001${path}`;
</script>

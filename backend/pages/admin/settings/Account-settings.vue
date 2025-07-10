<template>
  <div>
    <h1 class="text-3xl font-bold mb-6">Account Settings</h1>

    <div class="flex flex-col md:flex-row gap-0 px-6 mb-8 bg-white rounded-lg shadow p-6">
      <form class="w-full space-y-6" @submit.prevent="updateProfile" @reset="resetForm">

        <!-- Profile Picture Upload -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
          <div class="flex items-center space-x-4">
            <img
                v-if="form.profilePictureUrl"
                :src="form.profilePictureUrl"
                alt="Profile Preview"
                class="w-20 h-20 rounded-full object-cover"
            />
            <div v-else class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
              <span>No Image</span>
            </div>
            <input type="file" @change="handleFileUpload" class="text-sm" />
          </div>
        </div>

        <!-- Full Name -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
          <input
              type="text"
              v-model="form.fullName"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              required
          />
        </div>

        <!-- Username -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
          <input
              type="text"
              v-model="form.username"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              required
          />
        </div>

        <!-- Gmail -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Gmail</label>
          <input
              type="email"
              v-model="form.gmail"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              required
          />
        </div>

        <!-- Phone Number -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
          <input
              type="tel"
              v-model="form.phoneNumber"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
          />
        </div>

        <!-- Bio -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
          <textarea
              v-model="form.bio"
              rows="4"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
          ></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-4">
          <button
              type="submit"
              class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition"
          >
            Update Profile
          </button>
          <button
              type="reset"
              class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition"
          >
            Reset
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
definePageMeta({
  layout: 'admin',
  middleware: 'admin-auth'
})

import { ref, onMounted } from 'vue'
import { useUser } from '@/stores/useUser'

const user = useUser()

const form = ref({
  fullName: '',
  username: '',
  gmail: '',
  phoneNumber: '',
  bio: '',
  profilePictureUrl: ''
})

onMounted(() => {
  form.value.fullName = user.fullName
  form.value.username = user.username
  form.value.gmail = user.gmail
  form.value.phoneNumber = user.phoneNumber
  form.value.bio = user.bio
  form.value.profilePictureUrl = user.profilePictureUrl
})

const handleFileUpload = async (event) => {
  const file = event.target.files[0]
  if (file) {
    const formData = new FormData()
    formData.append('file', file)

    try {
      const response = await fetch('http://127.0.0.1:8000/api/admin/upload', {
        method: 'POST',
        body: formData,
        headers: {
          Authorization: `Bearer ${user.token}`,
        }
      })

      const result = await response.json()

      if (result.fileUrl) {
        form.value.profilePictureUrl = result.fileUrl
        console.log('✅ Uploaded File URL:', result.fileUrl)
      } else {
        console.error('❌ Upload failed:', result.error)
      }
    } catch (error) {
      console.error('❌ Upload request error:', error)
    }
  }
}

const updateProfile = async () => {
  try {
    await user.updateProfile({
      fullName: form.value.fullName,
      username: form.value.username,
      gmail: form.value.gmail,
      phoneNumber: form.value.phoneNumber,
      bio: form.value.bio,
      profilePictureUrl: form.value.profilePictureUrl
    })
    console.log('✅ Profile updated successfully')
  } catch (error) {
    console.error('❌ Failed to update profile:', error)
  }
}

const resetForm = () => {
  form.value.fullName = user.fullName
  form.value.username = user.username
  form.value.gmail = user.gmail
  form.value.phoneNumber = user.phoneNumber
  form.value.bio = user.bio
  form.value.profilePictureUrl = user.profilePictureUrl
}
</script>
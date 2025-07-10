
<template>
  <div class="max-w-4xl mx-auto py-10 px-4 space-y-6">
    <h1 class="text-2xl font-semibold">Edit Profile</h1>

    <form @submit.prevent="editProfile" class="space-y-4">
      <div>
        <label class="block font-medium">First Name</label>
        <input v-model="borrower.current_first_name" type="text" class="input" />
        <p v-if="errors.current_first_name" class="text-red-500 text-sm">{{ errors.current_first_name[0] }}</p>
      </div>

      <div>
        <label class="block font-medium">Last Name</label>
        <input v-model="borrower.current_last_name" type="text" class="input" />
        <p v-if="errors.current_last_name" class="text-red-500 text-sm">{{ errors.current_last_name[0] }}</p>
      </div>

      <div>
        <label class="block font-medium">Email</label>
        <input v-model="borrower.email" type="email" class="input" />
        <p v-if="errors.email" class="text-red-500 text-sm">{{ errors.email[0] }}</p>
      </div>

      <div>
        <label class="block font-medium">Phone Number</label>
        <input v-model="borrower.phone_number" type="text" class="input" />
        <p v-if="errors.phone_number" class="text-red-500 text-sm">{{ errors.phone_number[0] }}</p>
      </div>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useSanctumClient } from '#imports'

definePageMeta({
  layout: 'borrower',
  middleware: 'auth'
})

const client = useSanctumClient()
const borrower = ref({
  id: null,
  current_first_name: '',
  current_last_name: '',
  email: '',
  phone_number: ''
})
const errors = ref({})

// Fetch the user's current profile data
const fetchProfile = async () => {
  try {
    const { data } = await client('http://localhost:8000/api/borrower/profile', {
      credentials: 'include'
    })
    borrower.value = {
      id: data.id,
      current_first_name: data.first_name,
      current_last_name: data.last_name,
      email: data.email,
      phone_number: data.phone_number
    }
  } catch (err) {
    console.error('Fetch profile failed:', err)
  }
}

onMounted(fetchProfile)

// Submit profile update
const editProfile = async () => {
  errors.value = {} // Reset previous errors
  try {
    const formData = new FormData()
    formData.append('id', borrower.value.id)
    formData.append('current_first_name', borrower.value.current_first_name)
    formData.append('current_last_name', borrower.value.current_last_name)
    formData.append('email', borrower.value.email)
    formData.append('phone_number', borrower.value.phone_number)

    const response = await client('http://localhost:8000/api/borrower/profile', {
      method: 'POST',
      body: formData,
      credentials: 'include'
    })

    alert('Profile updated successfully.')
    await fetchProfile()
  } catch (err) {
    const data = err?.response?._data
    console.error('Update error:', data)
    if (data?.errors) {
      errors.value = data.errors
    } else {
      alert(data?.message || 'Failed to update profile.')
    }
  }
}
</script>

<style scoped>
.input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 0.375rem;
}
</style>


<script setup lang="ts">
import { ref } from 'vue'

const imageFile = ref<File | null>(null)
const imagePreview = ref<string | null>(null)
const isModalOpen = ref(false)
const fileName=ref<string | null>(null)

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  if (file) {
    imageFile.value = file
    imagePreview.value = URL.createObjectURL(file)
    fileName.value=file.name
  }
}

const openModal = () => {
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
}

const uploadImage = async () => {
  if (!imageFile.value) return alert('Please select an image')

  const formData = new FormData()
  formData.append('image', imageFile.value)

  try {
    const res = await $fetch('/api/upload', {
      method: 'POST',
      body: formData,
    })
    alert('Upload successful!')
    console.log(res)
  } catch (error) {
    console.error('Upload failed:', error)
    alert('Upload failed.')
  }
}
</script>

<template>
  <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-xl shadow space-y-6">
    <h1 class="text-2xl font-bold text-center">Upload Image</h1>

    <!-- File input -->
    <input
      type="file"
      accept="image/*"
      @change="handleFileChange"
      class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
    />

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

    <!-- Upload button -->
    <button
      @click="uploadImage"
      class="w-full py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
    >
      Upload
    </button>

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
</template>

<template>
    <div>
        <h1 class="text-3xl font-bold mb-6">Platform Settings</h1>
        <div class="flex flex-col md:flex-row gap-0 px-6 mb-8 bg-white rounded-lg shadow p-6">
    <div class="p-6">

        <!-- Platform Settings Form -->
        <div class="space-y-6">

            <!-- Default Currency -->
            <div class="flex items-center justify-items-end-safe">
                <label class="text-sm font-medium text-gray-700">Default Currency</label>
                <div class="px-4 flex items-center space-x-2">
                    <span class="text-purple-600 cursor-default">${{ settings.defaultCurrency }}</span>
                    <button @click="editSetting('defaultCurrency')" class="text-purple-600 hover:text-purple-800">
                        <Pen :size="18" />
                    </button>
                </div>
            </div>

            <!-- Transaction Fee -->
            <div class="flex items-center justify-items-end-safe">
                <label class="text-sm font-medium text-gray-700">Transaction Fee</label>
                <div class="px-4 flex items-center space-x-2">
                    <span class="text-purple-600 cursor-default">{{ settings.transactionFee }}%</span>
                    <button @click="editSetting('transactionFee')" class="text-purple-600 hover:text-purple-800">
                        <Pen :size="18" />
                    </button>
                </div>
            </div>

            <!-- Admin Contact Email -->
            <div class="flex items-center justify-items-end-safe">
                <label class="text-sm font-medium text-gray-700">Admin Contact Email</label>
                <div class="px-4 flex items-center space-x-2">
                    <span class="text-purple-600 cursor-default">{{ settings.adminEmail }}</span>
                    <button @click="editSetting('adminEmail')" class="text-purple-600 hover:text-purple-800">
                        <Pen :size="18" />
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-4 mt-6">
                <button
                    @click="updateSettings"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition"
                >
                    Update Setting
                </button>
                <button @click="resetSettings" class="text-gray-600 hover:text-gray-800">
                    Reset
                </button>
            </div>
        </div>

    </div>
        </div>
    </div>
</template>

<script setup>
definePageMeta({
  layout: 'admin',
  middleware: 'admin-auth'
})

import { ref } from 'vue'
import { Pen } from 'lucide-vue-next'

// Settings data
const settings = ref({
    defaultCurrency: 'USD',
    transactionFee: 2.5,
    adminEmail: 'admin@example.com'
})

// Edit action placeholder
const editSetting = (field) => {
    console.log(`Edit ${field} clicked`)
    // Trigger modal or inline edit here
}

// Update button action
const updateSettings = () => {
    console.log('Settings updated:', settings.value)
}

// Reset button action
const resetSettings = () => {
    settings.value = {
        defaultCurrency: 'USD',
        transactionFee: 2.5,
        adminEmail: 'admin@example.com'
    }
}
</script>

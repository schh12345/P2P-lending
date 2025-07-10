<template>
    <div>
        <h1 class="text-3xl font-bold mb-6">Loan Configurations</h1>
        <div class="flex flex-col md:flex-row gap-0 px-6 mb-8 bg-white rounded-lg shadow p-6">
    <div class="p-6">

        <!-- Loan Configuration -->
        <div class="space-y-6">


            <div class="flex items-center justify-items-end-safe">
                <label class="text-sm font-medium text-gray-700">Base Interest Rate</label>
                <div class="px-4 flex items-center space-x-2">
                    <span class="text-purple-600 cursor-default">${{ settings.defaultinterestrate }}</span>
                    <button @click="editSetting('defaultCurrency')" class="text-purple-600 hover:text-purple-800">
                        <Pen :size="18" />
                    </button>
                </div>
            </div>

            <!-- Loan Term -->
            <div class="flex items-center justify-items-end-safe">
                <label class="text-sm font-medium text-gray-700">Loan Term (Min-Max)</label>
                <div class="px-4 flex items-center space-x-2">
                    <span class="text-purple-600 cursor-default">{{ settings.loantime }}</span>
                    <button @click="editSetting('transactionFee')" class="text-purple-600 hover:text-purple-800">
                        <Pen :size="18" />
                    </button>
                </div>
            </div>

            <!-- Loan Amount -->
            <div class="flex items-center justify-items-end-safe">
                <label class="text-sm font-medium text-gray-700">Loan Amount (Min-Max)</label>
                <div class="px-4 flex items-center space-x-2">
                    <span class="text-purple-600 cursor-default">{{ settings.loanamount }}</span>
                    <button @click="editSetting('adminEmail')" class="text-purple-600 hover:text-purple-800">
                        <Pen :size="18" />
                    </button>
                </div>
            </div>

            <div class="flex flex-col items-start space-y-4">

                <!-- Title -->
                <label class="text-sm font-medium text-gray-700">Risk Based Adjustments</label>

                <!-- Low Income -->
                <div class="px-4 flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Low income</label>
                    <span class="text-purple-600 cursor-default">{{ settings.lowincome }}</span>
                    <button @click="editSetting('lowincome')" class="text-purple-600 hover:text-purple-800">
                        <Pen :size="18" />
                    </button>
                </div>

                <!-- Low Credit Card -->
                <div class="px-4 flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Low Credit Score</label>
                    <span class="text-purple-600 cursor-default">{{ settings.lowcs }}</span>
                    <button @click="editSetting('lowcc')" class="text-purple-600 hover:text-purple-800">
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
    defaultinterestrate: '5%',
    loantime: '1-3 Months',
    loanamount: '$500-$200,000',
    lowincome: '+1.2%',
    lowcs: '+2%',
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

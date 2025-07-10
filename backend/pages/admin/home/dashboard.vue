<template>
  <div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <h1 class="text-3xl font-bold mb-6 px-6 pt-6">Dashboard</h1>

    <!-- Metrics Section -->
    <div class="flex flex-col md:flex-row gap-0 px-6 mb-8 bg-white rounded-lg shadow">
      <!-- Card 1 -->
      <div class="flex-1 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-2">Total Active Users</h3>
        <p class="text-3xl font-bold text-blue-600">{{ totalUsers }}</p>

      </div>
      <div class="hidden md:flex items-center">
        <div class="h-16 border-l-2 border-dotted border-gray-400"></div>
      </div>

      <!-- Card 2 -->
      <div class="flex-1 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-2">Loan Requests</h3>
        <p class="text-3xl font-bold text-orange-600">{{ loanRequests }}</p>

      </div>
      <div class="hidden md:flex items-center">
        <div class="h-16 border-l-2 border-dotted border-gray-400"></div>
      </div>

      <!-- Card 3 -->
      <div class="flex-1 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-2">Approved Loans</h3>
        <p class="text-3xl font-bold text-green-600">{{ approvedLoans }}</p>

      </div>
      <div class="hidden md:flex items-center">
        <div class="h-16 border-l-2 border-dotted border-gray-400"></div>
      </div>

      <!-- Card 4 -->
      <div class="flex-1 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-2">Revenue</h3>
        <p class="text-3xl font-bold text-purple-600">${{ totalRevenue }}</p>

      </div>
    </div>

    <!-- Revenue Chart Section -->
    <div class="min-h-screen bg-gray-50 p-6">
      <div class="bg-white rounded-lg shadow-sm border border-blue-200 p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-2xl font-medium text-gray-800">Total Revenue</h2>
          <span class="text-gray-500 text-sm">{{ dateRange }}</span>
        </div>

        <div class="relative" style="height: 400px;">
          <div v-if="loading" class="flex items-center justify-center h-full">
            <div class="flex items-center space-x-2 text-gray-500">
              <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
              <span>Loading chart...</span>
            </div>
          </div>

          <canvas v-if="!loading && !error" ref="revenueChart" height="400"></canvas>

          <div v-if="error" class="flex items-center justify-center h-full">
            <div class="text-center text-red-600">
              <div class="w-12 h-12 text-red-500 mx-auto mb-2">⚠️</div>
              <p>Failed to load chart data</p>
            </div>
          </div>
        </div>

        <!-- Filter Buttons -->
        <div class="flex space-x-2 mt-4">
          <button v-for="period in periods" :key="period.value" @click="changePeriod(period.value)"
                  :class="[
              'px-4 py-2 rounded text-sm font-medium transition-all',
              selectedPeriod === period.value ? 'bg-blue-600 text-white' : 'bg-gray-100 hover:bg-gray-200'
            ]">
            {{ period.label }}
          </button>
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

import { ref, onMounted, nextTick, computed, watch } from 'vue'
import { Chart, registerables } from 'chart.js'
import { useNuxtApp } from '#app'
Chart.register(...registerables)

const { $axios } = useNuxtApp()

// Dashboard data
const totalUsers = ref(0)
const loanRequests = ref(0)
const approvedLoans = ref(0)
const totalRevenue = ref(0)

// Chart data
const revenueData = ref([])
const revenueChart = ref(null)
let chartInstance = null
const loading = ref(false)
const error = ref(false)

// Period filtering
const selectedPeriod = ref('month')
const periods = [
  { value: 'day', label: 'Day' },
  { value: 'month', label: 'Month' },
  { value: 'year', label: 'Year' }
]

// Date label
const dateRange = computed(() => {
  const now = new Date()
  if (selectedPeriod.value === 'day') {
    return now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
  } else if (selectedPeriod.value === 'year') {
    return `${now.getFullYear()} Revenue Overview`
  } else {
    return `${now.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })} Daily Revenue`
  }
})

// Fetch dashboard stats
const fetchDashboardStats = async () => {
  try {
    const response = await $axios.get('/admin/dashboard/stats')
    const stats = response.data.data
    totalUsers.value = stats.activeUsers
    loanRequests.value = stats.loanRequests
    approvedLoans.value = stats.approvedLoans
  } catch (err) {
    console.error('Failed to fetch dashboard stats:', err)
  }
}

// Fetch revenue data
const fetchRevenue = async () => {
  loading.value = true
  error.value = false

  try {
    let endpoint = ''
    if (selectedPeriod.value === 'day') endpoint = '/admin/daily-revenue'
    else if (selectedPeriod.value === 'year') endpoint = '/admin/yearly-revenue'
    else endpoint = '/admin/monthly-revenue'

    const response = await $axios.get(endpoint)

    if (response.data && response.data.success && response.data.data) {
      revenueData.value = response.data.data
      totalRevenue.value = revenueData.value.reduce((sum, item) => sum + (item.total || 0), 0)
    } else {
      throw new Error('Invalid response format')
    }
  } catch (err) {
    console.error('Error fetching revenue data:', err)
    error.value = true
  } finally {
    loading.value = false

    await nextTick()
    if (revenueChart.value) {
      renderChart()
    } else {
      console.error('Canvas element not available after loading.')
    }
  }
}

// Render chart
const renderChart = () => {
  if (!revenueChart.value) {
    console.error('Canvas element not available')
    return
  }

  if (chartInstance) {
    chartInstance.destroy()
  }

  const ctx = revenueChart.value.getContext('2d')
  let labels = []
  let data = []

  if (selectedPeriod.value === 'year') {
    labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    data = new Array(12).fill(0)

    revenueData.value.forEach(item => {
      if (item.month && item.month <= 12) {
        data[item.month - 1] = item.total
      }
    })
  } else if (selectedPeriod.value === 'month') {
    const daysInMonth = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate()
    labels = Array.from({ length: daysInMonth }, (_, i) => i + 1)
    data = new Array(daysInMonth).fill(0)

    revenueData.value.forEach(item => {
      if (item.day && item.day <= daysInMonth) {
        data[item.day - 1] = item.total
      }
    })
  } else if (selectedPeriod.value === 'day') {
    labels = Array.from({ length: 24 }, (_, i) => `${i}:00`)
    data = new Array(24).fill(0)

    revenueData.value.forEach(item => {
      if (item.hour !== undefined && item.hour <= 23) {
        data[item.hour] = item.total
      }
    })
  }

  chartInstance = new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Total Revenue',
        data,
        borderColor: '#4f46e5',
        backgroundColor: 'rgba(79, 70, 229, 0.1)',
        pointBackgroundColor: '#4f46e5',
        pointBorderColor: '#ffffff',
        pointBorderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 6,
        tension: 0.4,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: {
        intersect: false,
        mode: 'index',
      },
      plugins: {
        legend: {
          onClick: null,
          display: true,
          labels: { color: '#4f46e5' }
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          titleColor: 'white',
          bodyColor: 'white',
          borderColor: '#4f46e5',
          borderWidth: 1,
          callbacks: {
            label: (context) => `Revenue: $${context.raw}`
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: { color: 'rgba(0, 0, 0, 0.05)' },
          ticks: {
            callback: (value) => {
              if (value >= 1000000) return '$' + (value / 1000000).toFixed(1) + 'M'
              if (value >= 1000) return '$' + (value / 1000).toFixed(0) + 'K'
              return '$' + value
            }
          }
        },
        x: { grid: { color: 'rgba(0, 0, 0, 0.05)' } }
      }
    }
  })
}

// Period switch
const changePeriod = (period) => {
  selectedPeriod.value = period
}

// Watchers
watch(selectedPeriod, () => {
  fetchRevenue()
})

// Init
onMounted(() => {
  fetchDashboardStats()
  fetchRevenue()
})
</script>


<style scoped>
canvas {
  width: 100% !important;
  height: 100% !important;
}

button {
  background-color: #f9fafb;
  border: 1px solid #d1d5db;
}

button:hover {
  background-color: #e5e7eb;
}
</style>
<template>
  <div class="bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 px-6 pt-6">Analytics Overview</h1>

    <!-- Content -->
    <div class="flex flex-col md:flex-row gap-0 px-6 mb-8 bg-white rounded-lg shadow">

      <!-- Card 2 -->
      <div class="flex-1 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-2">Total Interest Earned</h3>
        <p class="text-3xl font-bold text-orange-600">{{totalInterest}}</p>

      </div>

      <!-- Divider -->
      <div class="hidden md:flex items-center">
        <div class="h-16 border-l-2 border-dotted border-gray-400"></div>
      </div>

      <!-- Card 3 -->
      <div class="flex-1 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-2">Active Loans</h3>
        <p class="text-3xl font-bold text-green-600">{{ totalRequests }}</p>

      </div>

      <!-- Divider -->
      <div class="hidden md:flex items-center">
        <div class="h-16 border-l-2 border-dotted border-gray-400"></div>
      </div>

      <!-- Card 4 -->
      <div class="flex-1 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-2">Total Lender</h3>
        <p class="text-3xl font-bold text-purple-600">{{ totalLenders }}</p>
      </div>
    </div>

    <!-- Statistics -->
    <div class="min-h-screen bg-gray-50 p-6">
      <!-- Loan Distribution Chart -->
      <div class="bg-white rounded-lg shadow-sm border border-blue-200 p-6 mb-6">
        <div class="flex justify-between items-center mb-8">
          <h2 class="text-2xl font-medium text-gray-800">Loan Distribution</h2>
        </div>

        <div v-if="chartData && chartData.length" class="relative h-96">
          <canvas ref="chartCanvas"></canvas>
        </div>

        <div v-else class="text-center text-gray-500 py-16">
          No chart data available.
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

import { ref, onMounted, nextTick } from 'vue'
import { Chart, LineController, LineElement, PointElement, LinearScale, Title, CategoryScale, Tooltip, Legend } from 'chart.js'
import { useNuxtApp } from '#app'

// Register Chart.js components
Chart.register(LineController, LineElement, PointElement, LinearScale, Title, CategoryScale, Tooltip, Legend)

const { $axios } = useNuxtApp()

const chartCanvas = ref(null)
const totalLenders = ref(0)
const users = ref([])
const totalRequests = ref(0)
const chartData = ref([])
const loading = ref(true)
const error = ref('')
const currentPage = ref(1)
const usersPerPage = ref(10)
const statusFilter = ref('all')
const totalInterest = ref(0)
const totalLoanDisbursed = ref(0)
// Fetch users and lenders
const fetchUsers = async () => {
  loading.value = true;
  try {
    const response = await $axios.get('/admin/users', {
      params: {
        role: 'lender',
        page: currentPage.value,
        per_page: usersPerPage.value,
        status: statusFilter.value !== 'all' ? statusFilter.value : undefined
      }
    });

    if (response.data && response.data.users) {
      users.value = response.data.users || [];
      totalLenders.value = response.data.total || 0;
      error.value = '';
    } else {
      throw new Error('Invalid response format');
    }
  } catch (err) {
    console.error('Error fetching users:', err);
    error.value = err.response?.data?.message || 'Failed to load users';
    users.value = [];
    totalLenders.value = 0;
  } finally {
    loading.value = false;
  }
}

const activeLoans = ref([])
const loadingActiveLoans = ref(true)
const errorActiveLoans = ref('')

const fetchRevenue = async () => {
  try {
    const response = await $axios.get('/admin/revenue', {
      params: { period: 'day' }
    });

    totalInterest.value = response.data.total_interest || 0;
  } catch (err) {
    console.error('Failed to fetch revenue:', err.response?.data?.message || err.message);
  }
};

const fetchLoanRequests = async () => {
  try {
    loading.value = true;
    error.value = null;

    const params = new URLSearchParams();
    params.append('page', currentPage.value);
    if (statusFilter.value) {
      params.append('status', statusFilter.value);
    }

    const response = await $axios.get(`/admin/loan-requests?${params.toString()}`);

    requests.value = response.data.data.data;

    // Total counts and stats
    totalRequests.value = response.data.data.total;
    totalApproved.value = response.data.stats.approved;
    totalPending.value = response.data.stats.pending;
    totalRejected.value = response.data.stats.rejected;
    totalLoanDisbursed.value = response.data.stats.total_amount || 0;

  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to fetch loan requests';
  } finally {
    loading.value = false;
  }
};

const fetchApprovedLoansTotal = async () => {
  try {
    const response = await $axios.get('/admin/loan-requests?status=Approved')
    totalLoanDisbursed.value = response.data.stats?.total_amount || 0
  } catch (err) {
    console.error('Failed to fetch approved loans:', err.response?.data?.message || err.message)
  }
}
// Fetch active loans
const fetchActiveLoans = async () => {
  loadingActiveLoans.value = true
  try {
    const response = await $axios.get('/admin/active-loans')
    if (response.data && response.data.success) {
      activeLoans.value = response.data.data
      totalRequests.value = activeLoans.value.length

      // Prepare chart data
      chartData.value = activeLoans.value.map((loan, index) => ({
        label: `Loan ${index + 1}`,
        amount: loan.request_amount
      }))

      await nextTick()
      renderChart()

      errorActiveLoans.value = ''
    } else {
      throw new Error('Invalid response format')
    }
  } catch (err) {
    console.error('Error fetching active loans:', err)
    errorActiveLoans.value = err.response?.data?.message || 'Failed to fetch active loans'
    activeLoans.value = []
    chartData.value = []
  } finally {
    loadingActiveLoans.value = false
  }
}

let chartInstance = null

// Render chart
const renderChart = () => {
  if (!chartCanvas.value) return

  const ctx = chartCanvas.value.getContext('2d')

  if (chartInstance) {
    chartInstance.destroy()
  }

  chartInstance = new Chart(ctx, {
    type: 'line',
    data: {
      labels: chartData.value.map((_, index) => index + 1),
      datasets: [{
        label: 'Active Loan Amount',
        data: chartData.value.map(item => item.amount),
        borderColor: '#9333ea',
        backgroundColor: 'rgba(147, 51, 234, 0.1)',
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true,
          onClick: null
        }
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Loan Number'
          },
          ticks: { stepSize: 1 }
        },
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Loan Amount (USD)'
          }
        }
      }
    }
  })
}

// Initialization
onMounted(() => {
  fetchUsers()
  fetchActiveLoans()
  fetchApprovedLoansTotal()
})
</script>


<style scoped>
canvas {
  width: 100% !important;
  height: 100% !important;
}
</style>
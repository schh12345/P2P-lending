<template>
  <div class="p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
      <!-- Header Section -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Loan Requests</h1>
        <p class="text-gray-600">Manage and review loan applications</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
              <FileText class="h-6 w-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Requests</p>
              <p class="text-2xl font-semibold text-gray-900">{{ totalRequests }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
              <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Approved</p>
              <p class="text-2xl font-semibold text-gray-900">
                {{ totalApproved }}
              </p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
              <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Pending</p>
              <p class="text-2xl font-semibold text-gray-900">{{ totalPending }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center">
            <div class="p-3 bg-red-100 rounded-lg">
              <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Rejected</p>
              <p class="text-2xl font-semibold text-gray-900">{{ totalRejected }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content Card -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Filter Section -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-4">
              <label class="text-sm font-medium text-gray-700">Filter by Status:</label>
              <select
                  v-model="statusFilter"
                  @change="handleFilterChange"
                  class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
              >
                <option value="">All Statuses</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="pending">Pending</option>
              </select>
            </div>
            <div class="text-sm text-gray-500">
              {{ requests.length }} of {{ totalRequests }} requests
            </div>
          </div>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="flex items-center justify-center py-16">
          <div class="flex items-center space-x-3">
            <div class="animate-spin rounded-full h-8 w-8 border-2 border-blue-600 border-t-transparent"></div>
            <span class="text-gray-600 font-medium">Loading loan requests...</span>
          </div>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="flex items-center justify-center py-16">
          <div class="text-center">
            <div class="text-red-600 mb-4 font-medium">{{ error }}</div>
            <button
                @click="fetchLoanRequests"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium"
            >
              Try Again
            </button>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else-if="requests.length === 0" class="flex items-center justify-center py-16">
          <div class="text-center">
            <div class="text-gray-400 mb-2">
              <FileText class="h-12 w-12 mx-auto" />
            </div>
            <div class="text-gray-600 font-medium">No loan requests found</div>
            <div class="text-gray-500 text-sm">Check back later for new applications</div>
          </div>
        </div>

        <!-- Mobile Card View -->
        <div v-else class="block lg:hidden">
          <div class="divide-y divide-gray-100">
            <div v-for="request in requests" :key="request.request_id" class="p-6 hover:bg-gray-50 transition-colors">
              <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                  <h3 class="text-lg font-semibold text-gray-900">
                    {{ request.borrower_firstname }} {{ request.borrower_lastname }}
                  </h3>
                  <p class="text-gray-600 text-sm">{{ request.borrower_email }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                      :class="{
                        'bg-green-100 text-green-800': request.status.toLowerCase() === 'approved',
                        'bg-red-100 text-red-800': request.status.toLowerCase() === 'rejected',
                        'bg-yellow-100 text-yellow-800': request.status.toLowerCase() === 'pending'
                      }">
                  {{ request.status }}
                </span>
              </div>

              <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-gray-50 rounded-lg p-3">
                  <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Amount</div>
                  <div class="text-lg font-semibold text-gray-900">${{ request.request_amount.toLocaleString() }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                  <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Duration</div>
                  <div class="text-lg font-semibold text-gray-900">{{ request.request_duration }}</div>
                </div>
              </div>

              <div class="mb-4">
                <div class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-1">Credit Score</div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                      :class="{
                        'bg-green-100 text-green-800': request.borrower_credit_score >= 700,
                        'bg-yellow-100 text-yellow-800': request.borrower_credit_score >= 600 && request.borrower_credit_score < 700,
                        'bg-red-100 text-red-800': request.borrower_credit_score < 600
                      }">
                  {{ request.borrower_credit_score }}
                </span>
              </div>

              <div class="flex space-x-2">
                <button
                    @click="viewRequest(request)"
                    class="flex-1 px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors"
                >
                  View Details
                </button>
                <button
                    @click="approveRequest(request)"
                    class="flex-1 px-4 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-colors"
                >
                  Approve
                </button>
                <button
                    @click="rejectRequest(request)"
                    class="flex-1 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors"
                >
                  Reject
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Desktop Table View -->
        <div v-else class="hidden lg:block">
          <table class="w-full">
            <thead>
            <tr class="border-b border-gray-100">
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Borrower</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Credit Score</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Loan Amount</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Duration</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
              <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            <tr v-for="request in requests" :key="request.request_id" class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-white font-medium text-sm">
                          {{ request.borrower_firstname.charAt(0) }}{{ request.borrower_lastname.charAt(0) }}
                        </span>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-semibold text-gray-900">
                      {{ request.borrower_firstname }} {{ request.borrower_lastname }}
                    </div>
                    <div class="text-sm text-gray-500">{{ request.borrower_email }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                        :class="{
                          'bg-green-100 text-green-800': request.borrower_credit_score >= 700,
                          'bg-yellow-100 text-yellow-800': request.borrower_credit_score >= 600 && request.borrower_credit_score < 700,
                          'bg-red-100 text-red-800': request.borrower_credit_score < 600
                        }">
                    {{ request.borrower_credit_score }}
                  </span>
              </td>
              <td class="px-6 py-4">
                <div class="text-sm font-semibold text-gray-900">${{ request.request_amount.toLocaleString() }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900">{{ request.request_duration }}</div>
              </td>
              <td class="px-6 py-4">
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                        :class="{
                          'bg-green-100 text-green-800': request.status.toLowerCase() === 'approved',
                          'bg-red-100 text-red-800': request.status.toLowerCase() === 'rejected',
                          'bg-yellow-100 text-yellow-800': request.status.toLowerCase() === 'pending'
                        }">
                    {{ request.status }}
                  </span>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end space-x-2">
                  <button
                      @click="viewRequest(request)"
                      class="px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors"
                  >
                    View
                  </button>
                  <button
                      @click="approveRequest(request)"
                      class="px-3 py-1.5 text-sm font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-colors"
                  >
                    Approve
                  </button>
                  <button
                      @click="rejectRequest(request)"
                      class="px-3 py-1.5 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors"
                  >
                    Reject
                  </button>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="!loading && !error && requests.length > 0 && totalPages > 1" class="px-6 py-4 border-t border-gray-100 bg-gray-50">
          <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-600">
              Showing {{ startIndex + 1 }} to {{ Math.min(startIndex + requestsPerPage, totalRequests) }} of {{ totalRequests }} results
            </div>

            <div class="flex items-center space-x-2">
              <button
                  @click="goToPrevious"
                  :disabled="currentPage === 1"
                  class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors"
                  :class="currentPage === 1 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-200'"
              >
                <ChevronLeft class="h-4 w-4 mr-1" />
                Previous
              </button>

              <div class="flex items-center space-x-1">
                <template v-for="(page, index) in getVisiblePages()" :key="index">
                  <button
                      v-if="page !== '...'"
                      @click="goToPage(page)"
                      class="px-3 py-2 text-sm font-medium rounded-lg transition-colors"
                      :class="page === currentPage ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-200'"
                  >
                    {{ page }}
                  </button>
                  <span v-else class="px-2 text-gray-400">...</span>
                </template>
              </div>

              <button
                  @click="goToNext"
                  :disabled="currentPage === totalPages"
                  class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors"
                  :class="currentPage === totalPages ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-200'"
              >
                Next
                <ChevronRight class="h-4 w-4 ml-1" />
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-lg max-h-[90vh] overflow-y-auto">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900">Loan Request Details</h3>
            <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <div class="space-y-4">
            <div class="bg-gray-50 rounded-xl p-4">
              <h4 class="font-semibold text-gray-900 mb-3">Borrower Information</h4>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <span class="text-sm text-gray-600">Name</span>
                  <p class="font-medium text-gray-900">{{ selectedRequest.borrower_firstname }} {{ selectedRequest.borrower_lastname }}</p>
                </div>
                <div>
                  <span class="text-sm text-gray-600">Credit Score</span>
                  <p class="font-medium text-gray-900">{{ selectedRequest.borrower_credit_score }}</p>
                </div>
              </div>
              <div class="mt-3">
                <span class="text-sm text-gray-600">Email</span>
                <p class="font-medium text-gray-900">{{ selectedRequest.borrower_email }}</p>
              </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-4">
              <h4 class="font-semibold text-gray-900 mb-3">Loan Details</h4>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <span class="text-sm text-gray-600">Amount</span>
                  <p class="font-medium text-gray-900">${{ selectedRequest.request_amount.toLocaleString() }}</p>
                </div>
                <div>
                  <span class="text-sm text-gray-600">Duration</span>
                  <p class="font-medium text-gray-900">{{ selectedRequest.request_duration }}</p>
                </div>
              </div>
              <div class="mt-3">
                <span class="text-sm text-gray-600">Status</span>
                <p class="font-medium"
                   :class="{
                     'text-green-600': selectedRequest.status.toLowerCase() === 'approved',
                     'text-red-600': selectedRequest.status.toLowerCase() === 'rejected',
                     'text-yellow-600': selectedRequest.status.toLowerCase() === 'pending'
                   }">
                  {{ selectedRequest.status }}
                </p>
              </div>
              <div class="mt-3">
                <span class="text-sm text-gray-600">Reason</span>
                <p class="font-medium text-gray-900">{{ selectedRequest.request_reason }}</p>
              </div>
            </div>
          </div>

          <div class="mt-6 flex justify-end space-x-3">
            <button
                @click="showModal = false"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors"
            >
              Close
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

import { Eye, ChevronLeft, ChevronRight, FileText } from 'lucide-vue-next'
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useNuxtApp } from '#app'

const { $axios } = useNuxtApp()

const router = useRouter()

const requests = ref([])
const loading = ref(false)
const error = ref(null)

const currentPage = ref(1)
const requestsPerPage = ref(10)

const totalRequests = ref(0)
const totalApproved = ref(0)
const totalPending = ref(0)
const totalRejected = ref(0)
const totalLoanAmount = ref(0)

const statusFilter = ref('')

const showModal = ref(false)
const selectedRequest = ref(null)

const totalPages = computed(() => Math.ceil(totalRequests.value / requestsPerPage.value))
const startIndex = computed(() => (currentPage.value - 1) * requestsPerPage.value)

const viewRequest = (request) => {
  router.push({
    path: '/admin/applications/loan-detail',
    query: {
      borrower_id: request.borrower_id,
      request_id: request.request_id,
    }
  })
}
const currentLoanTable = computed(() => {
  if (user.value.approval_status === 'Pending') return 'loanRequest';
  if (user.value.approval_status === 'Approved' && user.value.status === 'Active') return 'loans';
  if (user.value.approval_status === 'Approved' && user.value.status === 'Completed') return 'loan_after_approves';
  return null;
});
const fetchLoanRequests = async () => {
  try {
    loading.value = true
    error.value = null

    const params = new URLSearchParams()
    params.append('page', currentPage.value)
    if (statusFilter.value) {
      params.append('status', statusFilter.value)
    }

    const response = await $axios.get(`/admin/loan-requests?${params.toString()}`)

    requests.value = response.data.data.data

    // Use backend totals & stats
    totalRequests.value = response.data.stats?.total || 0
    totalApproved.value = response.data.stats?.approved || 0
    totalPending.value = response.data.stats?.pending || 0
    totalRejected.value = response.data.stats?.rejected || 0
    totalLoanAmount.value = response.data.stats?.total_amount || 0

  } catch (err) {
    console.error('Error fetching loan requests:', err)
    error.value = err.response?.data?.message || 'Failed to fetch loan requests'
  } finally {
    loading.value = false
  }
}

const handleFilterChange = () => {
  currentPage.value = 1
  fetchLoanRequests()
}

const approveRequest = async (request) => {
  try {
    await $axios.put(`/admin/loan-requests/${request.request_id}/approve`)
    alert('Loan request approved successfully!')
    await fetchLoanRequests()
  } catch (err) {
    console.error('Approval failed:', err.response?.data?.message || err.message)
    alert(`Approval failed: ${err.response?.data?.message || err.message}`)
  }
}

const rejectRequest = async (request) => {
  try {
    await $axios.put(`/admin/loan-requests/${request.request_id}/reject`)
    await fetchLoanRequests()
  } catch (err) {
    console.error('Rejection failed:', err.response?.data?.message || err.message)
    alert(`Rejection failed: ${err.response?.data?.message || err.message}`)
  }
}

const goToPrevious = () => {
  if (currentPage.value > 1) {
    currentPage.value -= 1
    fetchLoanRequests()
  }
}

const goToNext = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value += 1
    fetchLoanRequests()
  }
}

const goToPage = (page) => {
  if (page !== '...' && page !== currentPage.value) {
    currentPage.value = page
    fetchLoanRequests()
  }
}

const getVisiblePages = () => {
  const pages = []
  const total = totalPages.value
  const current = currentPage.value

  if (total <= 1) return []

  pages.push(1)

  if (total <= 7) {
    for (let i = 2; i <= total; i++) {
      pages.push(i)
    }
  } else {
    if (current <= 4) {
      for (let i = 2; i <= 5; i++) {
        pages.push(i)
      }
      pages.push('...')
      pages.push(total)
    } else if (current >= total - 3) {
      pages.push('...')
      for (let i = total - 4; i <= total; i++) {
        pages.push(i)
      }
    } else {
      pages.push('...')
      for (let i = current - 1; i <= current + 1; i++) {
        pages.push(i)
      }
      pages.push('...')
      pages.push(total)
    }
  }

  return pages
}

onMounted(() => {
  fetchLoanRequests()
})

</script>
<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto">
      <!-- Header -->
      <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between">
          <button @click="goBack" class="text-gray-600 hover:text-gray-800 flex items-center transition-colors">
            <ChevronLeft size="20" class="mr-2" /> Back to Loan Requests
          </button>
          <h1 class="text-2xl font-bold text-gray-800">Loan Request Overview</h1>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="bg-white rounded-lg shadow-sm p-12">
        <div class="text-center">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
          <p class="text-gray-600">Loading loan details...</p>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-white rounded-lg shadow-sm p-12">
        <div class="text-center">
          <div class="text-red-500 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Error Loading Data</h3>
          <p class="text-red-600">{{ error }}</p>
        </div>
      </div>

      <!-- Pending Loan Request -->
      <div v-else-if="isStatus('Pending') && loanRequest && Object.keys(loanRequest).length" class="space-y-6">
        <!-- Status Badge -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Loan Request Details</h2>
            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
              {{ loanStatus }}
            </span>
          </div>
        </div>

        <!-- Borrower Information -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Borrower Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-3">
              <div>
                <label class="text-sm font-medium text-gray-500">Full Name</label>
                <p class="text-gray-900 font-medium">{{ loanRequest.borrower?.first_name }} {{ loanRequest.borrower?.last_name }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Email Address</label>
                <p class="text-gray-900">{{ loanRequest.borrower?.email }}</p>
              </div>
            </div>
            <div class="space-y-3">
              <div>
                <label class="text-sm font-medium text-gray-500">Phone Number</label>
                <p class="text-gray-900">{{ loanRequest.borrower?.phone_number || 'N/A' }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Credit Score</label>
                <p class="text-gray-900">{{ loanRequest.borrower?.credit_score || 'N/A' }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Loan Details -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Loan Request Details</h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
              <label class="text-sm font-medium text-blue-600">Requested Amount</label>
              <p class="text-2xl font-bold text-blue-800">${{ formatNumber(loanRequest.request_amount) }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
              <label class="text-sm font-medium text-green-600">Duration</label>
              <p class="text-2xl font-bold text-green-800">{{ loanRequest.request_duration }} months</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
              <label class="text-sm font-medium text-purple-600">Request Date</label>
              <p class="text-lg font-bold text-purple-800">{{ formatDate(loanRequest.created_at) }}</p>
            </div>
          </div>
          <div class="mt-4">
            <label class="text-sm font-medium text-gray-500">Reason for Loan</label>
            <p class="text-gray-900 mt-1 p-3 bg-gray-50 rounded-lg">{{ loanRequest.request_reason }}</p>
          </div>
        </div>
      </div>

      <!-- Approved Loan -->
      <div v-else-if="isStatus('Approved') && approvedLoan && Object.keys(approvedLoan).length" class="space-y-6">
        <!-- Status Badge -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Approved Loan Details</h2>
            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
              {{ loanStatus }}
            </span>
          </div>
        </div>

        <!-- Borrower Information -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Borrower And Loan Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-3">
              <div>
                <label class="text-sm font-medium text-gray-500">Borrower ID</label>
                <p class="text-gray-900 font-medium">{{ approvedLoan.BorrowerID }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Request ID</label>
                <p class="text-gray-900">{{ approvedLoan.request_id }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Loan Details -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Loan Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
              <label class="text-sm font-medium text-blue-600">Loan Amount</label>
              <p class="text-2xl font-bold text-blue-800">${{ formatNumber(approvedLoan.request_amount) }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
              <label class="text-sm font-medium text-green-600">Interest Rate</label>
              <p class="text-2xl font-bold text-green-800">{{ approvedLoan.interest_rate }}%</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
              <label class="text-sm font-medium text-purple-600">Duration</label>
              <p class="text-lg font-bold text-purple-800">{{ approvedLoan.request_duration }} days</p>
            </div>
            <div class="bg-orange-50 p-4 rounded-lg">
              <label class="text-sm font-medium text-orange-600">Total Amount</label>
              <p class="text-lg font-bold text-orange-800">${{ formatNumber(approvedLoan.total) }}</p>
            </div>
          </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Loan Timeline</h3>
          <div class="space-y-4">
            <div class="flex items-center space-x-3">
              <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
              <div>
                <p class="text-sm font-medium text-gray-900">Request Created</p>
                <p class="text-sm text-gray-500">{{ formatDateTime(approvedLoan.created_at) }}</p>
              </div>
            </div>
            <div v-if="approvedLoan.approved_at" class="flex items-center space-x-3">
              <div class="w-3 h-3 bg-green-500 rounded-full"></div>
              <div>
                <p class="text-sm font-medium text-gray-900">Approved</p>
                <p class="text-sm text-gray-500">{{ formatDateTime(approvedLoan.approved_at) }}</p>
              </div>
            </div>
            <div v-if="approvedLoan.completed_at" class="flex items-center space-x-3">
              <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
              <div>
                <p class="text-sm font-medium text-gray-900">Completed</p>
                <p class="text-sm text-gray-500">{{ formatDateTime(approvedLoan.completed_at) }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Loan Reason -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Loan Reason</h3>
          <p class="text-gray-900 p-3 bg-gray-50 rounded-lg">{{ approvedLoan.request_reason }}</p>
        </div>
      </div>

      <!-- Completed/Final Loan -->
      <div v-else-if="loanAfterApprove && Object.keys(loanAfterApprove).length" class="space-y-6">
        <!-- Status Badge -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Final Loan Details</h2>
            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
              {{ loanAfterApprove.status || 'Completed' }}
            </span>
          </div>
        </div>

        <!-- Borrower Information -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Borrower Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-3">
              <div>
                <label class="text-sm font-medium text-gray-500">Full Name</label>
                <p class="text-gray-900 font-medium">{{ loanAfterApprove.borrower_firstname }} {{ loanAfterApprove.borrower_lastname }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Email Address</label>
                <p class="text-gray-900">{{ loanAfterApprove.borrower_email }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Final Loan Details -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Loan Summary</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
              <label class="text-sm font-medium text-blue-600">Original Amount</label>
              <p class="text-2xl font-bold text-blue-800">${{ formatNumber(loanAfterApprove.amount) }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
              <label class="text-sm font-medium text-green-600">Total Amount</label>
              <p class="text-2xl font-bold text-green-800">${{ formatNumber(loanAfterApprove.total) }}</p>
            </div>
            <div class="bg-red-50 p-4 rounded-lg">
              <label class="text-sm font-medium text-red-600">Late Days</label>
              <p class="text-2xl font-bold text-red-800">{{ loanAfterApprove.lateDay || '0' }}</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
              <label class="text-sm font-medium text-purple-600">Status</label>
              <p class="text-lg font-bold text-purple-800">{{ loanAfterApprove.status || 'Completed' }}</p>
            </div>
          </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Loan Timeline</h3>
          <div class="space-y-4">
            <div v-if="loanAfterApprove.approved_at" class="flex items-center space-x-3">
              <div class="w-3 h-3 bg-green-500 rounded-full"></div>
              <div>
                <p class="text-sm font-medium text-gray-900">Approved</p>
                <p class="text-sm text-gray-500">{{ formatDateTime(loanAfterApprove.approved_at) }}</p>
              </div>
            </div>
            <div v-if="loanAfterApprove.completed_at" class="flex items-center space-x-3">
              <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
              <div>
                <p class="text-sm font-medium text-gray-900">Completed</p>
                <p class="text-sm text-gray-500">{{ formatDateTime(loanAfterApprove.completed_at) }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Reason -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Loan Reason</h3>
          <p class="text-gray-900 p-3 bg-gray-50 rounded-lg">{{ loanAfterApprove.request_reason }}</p>
        </div>
      </div>

      <!-- No Data Found -->
      <div v-else class="bg-white rounded-lg shadow-sm p-12">
        <div class="text-center">
          <div class="text-gray-400 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">No Data Found</h3>
          <p class="text-gray-600">The loan request you're looking for doesn't exist or has been removed.</p>
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

import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { ChevronLeft } from 'lucide-vue-next';
import { useNuxtApp } from '#app';

const { $axios } = useNuxtApp();
const route = useRoute();
const router = useRouter();

const requestId = route.query.request_id;
const loading = ref(false);
const error = ref(null);

// Store data for each condition
const loanRequest = ref({});
const approvedLoan = ref({});
const loanAfterApprove = ref({});

const loanStatus = ref(null); // Status of the loan

const goBack = () => router.push('/admin/applications/loan-management');

// Helper functions
const formatNumber = (number) => {
  if (!number) return '0.00';
  return new Intl.NumberFormat('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(number);
};

const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

const formatDateTime = (dateString) => {
  if (!dateString) return 'N/A';
  return new Date(dateString).toLocaleString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

const isStatus = (status) => {
  return loanStatus.value?.toLowerCase() === status.toLowerCase();
};

const fetchLoanDetails = async () => {
  try {
    loading.value = true;
    error.value = null;

    const statusRes = await $axios.get(`/admin/loan-requests/${requestId}/status`);
    loanStatus.value = statusRes.data.data.status;

    console.log('Raw Status Response:', statusRes.data.data.status);

    const normalizedStatus = loanStatus.value?.toLowerCase();

    if (normalizedStatus === 'pending') {
      const res = await $axios.get(`/admin/loan-requests/${requestId}`);
      loanRequest.value = res.data.data;

      console.log('Loan Status:', loanStatus.value);
      console.log('Loan Request Data:', JSON.parse(JSON.stringify(loanRequest.value)));

    } else if (normalizedStatus === 'approved') {
      const res = await $axios.get(`/admin/loans/request/${requestId}`);
      approvedLoan.value = res.data.data;

      console.log('Loan Status:', loanStatus.value);
      console.log('Approved Loan Data:', JSON.parse(JSON.stringify(approvedLoan.value)));

    } else {
      const res = await $axios.get(`/admin/loan-after-approves/${requestId}`);
      loanAfterApprove.value = res.data.data;

      console.log('Loan Status:', loanStatus.value);
      console.log('Loan After Approve Data:', JSON.parse(JSON.stringify(loanAfterApprove.value)));
    }

  } catch (err) {
    console.error('Error fetching loan details:', err);
    error.value = err.response?.data?.message || 'Failed to load loan details';
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  if (requestId) {
    fetchLoanDetails();
  } else {
    error.value = 'No loan request ID provided. Please access this page through the Loan Management section.';
  }
});
</script>
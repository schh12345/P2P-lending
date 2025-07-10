<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-5xl mx-auto bg-white rounded-lg shadow p-6">
      <div class="flex items-center justify-between mb-6">
        <button @click="goBack" class="text-gray-600 hover:text-gray-800 flex items-center">
          <ChevronLeft size="20" class="mr-2" /> Back to Loan Requests
        </button>
        <h2 class="text-xl font-semibold text-gray-800">Loan Request Overview</h2>
      </div>

      <!-- Loading and error -->
      <div v-if="loading" class="text-center py-12 text-gray-600">Loading...</div>
      <div v-else-if="error" class="text-center py-12 text-red-600">{{ error }}</div>

      <!-- Pending table -->
      <div v-else-if="loanStatus === 'Pending' && loanRequest && Object.keys(loanRequest).length">
        <h3 class="text-lg font-semibold mb-4">Pending Loan Request Details</h3>
        <p><strong>Borrower:</strong> {{ loanRequest.borrower_firstname }} {{ loanRequest.borrower_lastname }}</p>
        <p><strong>Borrower Email:</strong> {{ loanRequest.borrower_email }}</p>
        <p><strong>Amount:</strong> ${{ loanRequest.request_amount }}</p>
        <p><strong>Duration:</strong> {{ loanRequest.request_duration }} months</p>
        <p><strong>Reason:</strong> {{ loanRequest.request_reason }}</p>
      </div>

      <!-- Approved table -->
      <div v-else-if="loanStatus === 'Approved' && approvedLoan && Object.keys(approvedLoan).length">
        <h3 class="text-lg font-semibold mb-4">Approved Loan Details</h3>
        <p><strong>Amount:</strong> ${{ approvedLoan.amount }}</p>
        <p><strong>Interest Rate:</strong> {{ approvedLoan.interest_rate }}%</p>
        <p><strong>Start Date:</strong> {{ new Date(approvedLoan.start_date).toLocaleDateString() }}</p>
        <p><strong>Payment Date:</strong> {{ new Date(approvedLoan.payment_date).toLocaleDateString() }}</p>
        <p><strong>Status:</strong> {{ approvedLoan.status }}</p>
      </div>

      <!-- Completed or after approve table -->
      <div v-else-if="loanAfterApprove && Object.keys(loanAfterApprove).length">
        <h3 class="text-lg font-semibold mb-4">Final Loan Details</h3>
        <p><strong>Borrower:</strong> {{ loanAfterApprove.borrower_firstname }} {{ loanAfterApprove.borrower_lastname }}</p>
        <p><strong>Borrower Email:</strong> {{ loanAfterApprove.borrower_email }}</p>
        <p><strong>Amount:</strong> ${{ loanAfterApprove.amount }}</p>
        <p><strong>Total:</strong> ${{ loanAfterApprove.total }}</p>
        <p><strong>Late Days:</strong> {{ loanAfterApprove.lateDay || '0' }}</p>
        <p><strong>Completed At:</strong> {{ loanAfterApprove.completed_at ? new Date(loanAfterApprove.completed_at).toLocaleString() : 'N/A' }}</p>
        <p><strong>Approved At:</strong> {{ loanAfterApprove.approved_at ? new Date(loanAfterApprove.approved_at).toLocaleString() : 'N/A' }}</p>
        <p><strong>Reason:</strong> {{ loanAfterApprove.request_reason }}</p>
      </div>

      <!-- Fallback -->
      <div v-else class="text-gray-600 text-center py-12">
        No data to display.
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

const fetchLoanDetails = async () => {
  try {
    loading.value = true;
    error.value = null;


    const statusRes = await $axios.get(`/admin/loan-requests/${requestId}/status`);

    loanStatus.value = statusRes.data.data.status;


    if (loanStatus.value === 'Pending') {
      const res = await $axios.get(`/admin/loan-requests/${requestId}`);
      loanRequest.value = res.data.data;
    } else if (loanStatus.value === 'Approved') {
      const res = await $axios.get(`/admin/loans/${requestId}`);
      approvedLoan.value = res.data.data;
    } else {

      const res = await $axios.get(`/admin/loan-after-approves/${requestId}`);
      loanAfterApprove.value = res.data.data;
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
    error.value = 'Please view in the Loan Management page';
  }
});
</script>

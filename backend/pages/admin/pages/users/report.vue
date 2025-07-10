<template>
  <div class="min-h-screen bg-gray-50 p-3 sm:p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Header with back button -->
      <div class="flex items-center items-center mb-6">
        <div class="flex items-center gap-4">
          <button @click="goBack" class="flex items-center text-gray-600 hover:text-gray-800 transition-colors mb-2">
            <ChevronLeft size="20" class="mr-1" />
            Back to User Management
          </button>
          <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center">User Report</h1>
        </div>
      </div>

      <!-- Direct Access Message -->
      <div v-if="isDirectAccess" class="flex items-center justify-center py-12">
        <div class="text-center px-4">
          <div class="text-red-600 mb-2 text-lg font-semibold">
            Please access this page through User Management.
          </div>
          <button @click="goBack" class="text-indigo-600 hover:text-indigo-500 text-sm font-medium mt-4">Back to User Management</button>
        </div>
      </div>

      <!-- Loading State -->
      <div v-else-if="loading" class="flex items-center justify-center py-12">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
        <span class="ml-3 text-gray-600">Loading user details...</span>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="flex items-center justify-center py-12">
        <div class="text-center px-4">
          <div class="text-red-600 mb-2">{{ error }}</div>
          <button @click="fetchUserDetails" class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">Try again</button>
        </div>
      </div>

      <!-- User Report Cards -->
      <div v-else-if="user" class="space-y-6">
        <!-- User Profile Card -->
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center space-x-4 mb-4">
            <div class="h-16 w-16 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 flex items-center justify-center text-white font-medium text-xl">
              {{ getInitials(user.first_name, user.last_name) }}
            </div>
            <div>
              <h2 class="text-2xl font-bold text-gray-900">{{ user.first_name }} {{ user.last_name }}</h2>
              <p class="text-gray-600">{{ formatUserType(user.table_type) }}</p>
              <span :class="`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1 ${getStatusBadgeClass(user.status)}`">
                <span :class="`w-1.5 h-1.5 rounded-full mr-1.5 ${getStatusDotClass(user.status)}`"></span>
                {{ getDisplayStatus(user) }}
              </span>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-sm font-medium text-gray-500">Email</p>
              <p class="text-sm text-gray-900 mt-1">{{ user.email }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-sm font-medium text-gray-500">Phone</p>
              <p class="text-sm text-gray-900 mt-1">{{ user.phone_number || 'N/A' }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-sm font-medium text-gray-500">Credit Score</p>
              <span :class="`inline-flex items-center px-2 py-1 rounded-full text-xs font-medium mt-1 ${user.credit_score >= 700 ? 'bg-green-100 text-green-800' : user.credit_score >= 600 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}`">
                {{ user.credit_score || 'N/A' }}
              </span>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-sm font-medium text-gray-500">Amount</p>
              <p class="text-sm font-semibold text-gray-900 mt-1">{{ formatAmount(user.amount) }}</p>
            </div>
          </div>
        </div>

        <!-- Metrics Section -->
        <div class="flex flex-col md:flex-row gap-0 bg-white rounded-lg shadow">
          <!-- Card 1: Role Information -->
          <div class="flex-1 p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-2">User Role</h3>
            <p class="text-3xl font-bold text-blue-600">{{ formatUserType(user.table_type) }}</p>
            <p class="text-sm text-gray-600 mt-1">
              {{ user.table_type === 'borrower' ? 'Seeking loans' : 'Providing loans' }}
            </p>
            <div class="mt-2">
              <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                Member since {{ formatJoinDate(user.created_at) }}
              </span>
            </div>
          </div>

          <div class="hidden md:flex items-center">
            <div class="h-16 border-l-2 border-dotted border-gray-400"></div>
          </div>

          <!-- Card 2: Active Loans -->
          <div class="flex-1 p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Active Loans</h3>
            <p class="text-3xl font-bold text-orange-600">{{ activeLoans }}</p>
            <p class="text-sm text-green-600 mt-1">
              {{ user.table_type === 'borrower' ? 'Loans received' : 'Loans provided' }}
            </p>
            <div class="mt-2">
              <span class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full">
                Total: {{ formatAmount(totalLoanAmount) }}
              </span>
            </div>
          </div>

          <div class="hidden md:flex items-center">
            <div class="h-16 border-l-2 border-dotted border-gray-400"></div>
          </div>

          <!-- Card 3: Join Date & Activity -->
          <div class="flex-1 p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Account Created</h3>
            <p class="text-3xl font-bold text-green-600">{{ formatJoinDate(user.created_at) }}</p>
            <p class="text-sm text-gray-600 mt-1">{{ getDaysActive(user.created_at) }} days active</p>
            <div class="mt-2">
              <span :class="`text-xs px-2 py-1 rounded-full ${user.status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}`">
                {{ user.status === 'Active' ? 'Currently active' : 'Inactive user' }}
              </span>
            </div>
          </div>
        </div>

        <!-- Additional Details Card -->
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Account Status Section -->
            <div>
              <h4 class="text-sm font-medium text-gray-700 mb-3">Account Status</h4>
              <div class="space-y-2">
                <div class="flex justify-between">
                  <span class="text-sm text-gray-600">Status:</span>
                  <span class="text-sm font-medium">{{ user.status }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm text-gray-600">Approval Status:</span>
                  <span class="text-sm font-medium">{{ user.approval_status || 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm text-gray-600">User Type:</span>
                  <span class="text-sm font-medium">{{ formatUserType(user.table_type) }}</span>
                </div>
              </div>
            </div>

            <!-- Financial and Employment Information Section -->
            <div>
              <h4 class="text-sm font-medium text-gray-700 mb-3">Financial Information</h4>
              <div class="space-y-2">
                <div class="flex justify-between">
                  <span class="text-sm text-gray-600">Requested/Offered Amount:</span>
                  <span class="text-sm font-medium">{{ formatAmount(user.amount) }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm text-gray-600">Credit Score:</span>
                  <span class="text-sm font-medium">{{ user.credit_score || 'Not provided' }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm text-gray-600">Risk Level:</span>
                  <span :class="`text-sm font-medium ${getRiskColor(user.credit_score)}`">
                    {{ getRiskLevel(user.credit_score) }}
                  </span>
                </div>

              </div>
            </div>
          </div>
        </div>

        <!-- Only show employment information for borrowers -->
        <template v-if="user.table_type === 'borrower' && (user.identity_path || user.employment_path)">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Identity Document Card -->
            <div v-if="user.identity_path" class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
              <h4 class="text-sm font-medium text-gray-700 mb-3">Identity Document</h4>
              <template v-if="isPdf(user.identity_path)">
                <a
                    :href="user.identity_path"
                    target="_blank"
                    rel="noopener"
                    class="text-indigo-600 hover:underline text-sm font-medium"
                >
                  View Identity Document (PDF)
                </a>
              </template>
              <template v-else>
                <img
                    :src="user.identity_path"
                    alt="Identity Document"
                    class="max-w-full h-auto rounded-md shadow-md"
                />
              </template>
            </div>

            <!-- Employment Document Card -->
            <div v-if="user.employment_path" class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
              <h4 class="text-sm font-medium text-gray-700 mb-3">Employment Document</h4>
              <template v-if="isPdf(user.employment_path)">
                <a
                    :href="user.employment_path"
                    target="_blank"
                    rel="noopener"
                    class="text-indigo-600 hover:underline text-sm font-medium"
                >
                  View Employment Document (PDF)
                </a>
              </template>
              <template v-else>
                <img
                    :src="user.employment_path"
                    alt="Employment Document"
                    class="max-w-full h-auto rounded-md shadow-md"
                />
              </template>
            </div>
          </div>
        </template>


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
import { ChevronLeft } from 'lucide-vue-next';
import { useRoute, useRouter } from 'vue-router';
import { useNuxtApp } from '#app';

const { $axios } = useNuxtApp();

const route = useRoute();
const router = useRouter();

const userId = route.query.id;
const tableType = route.query.table_type;

const user = ref(null);
const loading = ref(false);
const error = ref(null);
const activeLoans = ref(0);
const totalLoanAmount = ref(0);

const isDirectAccess = ref(!userId || !tableType);

const fetchUserDetails = async () => {
  loading.value = true;
  error.value = null;

  try {
    const response = await $axios.get(`/admin/users/${tableType}/${userId}`);
    user.value = response.data.user;

    await fetchUserLoans();
  } catch (err) {
    console.error('Error fetching user details:', err);
    error.value = err.response?.data?.message || 'Failed to fetch user details';
  } finally {
    loading.value = false;
  }
};
const isPdf = (path) => {
  return path && path.toLowerCase().endsWith('.pdf');
};
const fetchUserLoans = async () => {
  try {
    activeLoans.value = Math.floor(Math.random() * 5) + 1;
    totalLoanAmount.value = Math.floor(Math.random() * 50000) + 10000;
  } catch (err) {
    console.error('Error fetching user loans:', err);
    activeLoans.value = 0;
    totalLoanAmount.value = 0;
  }
};


const getFullImageUrl = (path) => {
  if (!path) return '';

  if (path.startsWith('http://') || path.startsWith('https://')) {
    return path;
  }

  const API_BASE_URL = 'http://127.0.0.1:8000';

  return `${API_BASE_URL}/${path.replace(/^\/+/, '')}`;
};


const goBack = () => {
  router.push('/admin/pages/users/user-management');
};

const getInitials = (firstName, lastName) => {
  return `${firstName?.charAt(0) || ''}${lastName?.charAt(0) || ''}`.toUpperCase();
};

const getStatusBadgeClass = (status) => {
  const classes = {
    active: 'bg-green-100 text-green-800',
    inactive: 'bg-gray-100 text-gray-800',
    pending: 'bg-yellow-100 text-yellow-800',
    suspended: 'bg-red-100 text-red-800',
    approved: 'bg-blue-100 text-blue-800',
    verified: 'bg-purple-100 text-purple-800',
    rejected: 'bg-red-100 text-red-800',
  };
  return classes[status?.toLowerCase()] || 'bg-gray-100 text-gray-800';
};

const getStatusDotClass = (status) => {
  const classes = {
    active: 'bg-green-400',
    inactive: 'bg-gray-400',
    pending: 'bg-yellow-400',
    suspended: 'bg-red-400',
    approved: 'bg-blue-400',
    verified: 'bg-purple-400',
  };
  return classes[status?.toLowerCase()] || 'bg-gray-400';
};

const formatUserType = (tableType) => {
  return tableType?.charAt(0).toUpperCase() + tableType?.slice(1) || 'User';
};

const formatAmount = (amount) => {
  if (!amount) return '$0.00';
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD'
  }).format(amount);
};

const getDisplayStatus = (user) => {
  if (user.status === 'Suspended') return 'Suspended';
  if (user.status === 'Active') return 'Active';
  if (user.approval_status === 'Pending') return 'Pending';
  if (user.approval_status === 'Rejected') return 'Rejected';
  if (user.approval_status === 'Approved') return 'Approved';
  return 'Inactive';
};

const formatJoinDate = (dateString) => {
  if (!dateString) return 'Unknown';
  const date = new Date(dateString);
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

const getDaysActive = (dateString) => {
  if (!dateString) return 0;
  const joinDate = new Date(dateString);
  const today = new Date();
  const diffTime = Math.abs(today - joinDate);
  return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
};

const getRiskLevel = (creditScore) => {
  if (!creditScore) return 'Unknown';
  if (creditScore >= 80) return 'Low Risk';
  if (creditScore >= 50) return 'Medium Risk';
  return 'High Risk';
};

const getRiskColor = (creditScore) => {
  if (!creditScore) return 'text-gray-600';
  if (creditScore >= 80) return 'text-green-600';
  if (creditScore >= 50) return 'text-yellow-600';
  return 'text-red-600';
};

onMounted(() => {
  if (!isDirectAccess.value) {
    fetchUserDetails();
  }
});
</script>
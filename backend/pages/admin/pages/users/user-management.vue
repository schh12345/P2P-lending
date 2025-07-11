<template>
  <div class="min-h-screen bg-gray-50 p-3 sm:p-6">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6 text-gray-900">User Management</h1>

      <!-- Filters -->
      <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row gap-3 sm:gap-4">
        <div class="flex items-center gap-2">
          <label class="text-sm font-medium text-gray-700 whitespace-nowrap">Status:</label>
          <select v-model="statusFilter" class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            <option value="all">All</option>
            <option value="pending">Pending (Approval)</option>
            <option value="approved">Approved (Approval)</option>
            <option value="rejected">Rejected (Approval)</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="suspended">Suspended</option>
          </select>
        </div>

        <div class="flex items-center gap-2">
          <label class="text-sm font-medium text-gray-700 whitespace-nowrap">Role:</label>
          <select v-model="roleFilter" class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            <option value="borrower">Borrower</option>
            <option value="lender">Lender</option>
          </select>
        </div>

        <input
            v-model="searchQuery"
            type="text"
            placeholder="Search by name..."
            class="border rounded px-3 py-2 text-sm w-full sm:w-64 focus:ring-indigo-500 focus:border-indigo-500"
        />

        <button @click="fetchUsers" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 focus:ring-indigo-500">
          Refresh
        </button>
      </div>


      <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-3 sm:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
          <h2 class="text-lg font-semibold text-gray-900">Users</h2>
          <span class="text-sm text-gray-500">{{ totalUsers }} users</span>
        </div>

        <div v-if="loading" class="flex items-center justify-center py-12">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
          <span class="ml-3 text-gray-600">Loading users...</span>
        </div>

        <div v-else-if="error" class="flex items-center justify-center py-12">
          <div class="text-center px-4">
            <div class="text-red-600 mb-2">{{ error }}</div>
            <button @click="fetchUsers" class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">Try again</button>
          </div>
        </div>



        <div v-else-if="users.length === 0" class="flex items-center justify-center py-12">
          <div class="text-center px-4">
            <div class="text-gray-500 mb-2">No users found</div>
            <p class="text-sm text-gray-400">Try adjusting your filters</p>
          </div>
        </div>

        <!-- Mobile Card View (visible on small screens) -->
        <div v-else class="block sm:hidden">
          <div class="px-3 py-2 border-b border-gray-200"></div>
          <div class="divide-y divide-gray-200">
            <div v-for="user in users" :key="`${user.table_type}-${user.id}`" class="p-4">
              <div class="flex items-start justify-between mb-3">
                <div class="flex items-center">
                  <input
                      type="checkbox"
                      :checked="selectedUsers.has(`${user.table_type}-${user.id}`)"
                      @change="() => handleSelectUser(`${user.table_type}-${user.id}`)"
                      class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-3"
                  />
                  <div class="h-10 w-10 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 flex items-center justify-center text-white font-medium text-sm">
                    {{ getInitials(user.first_name, user.last_name) }}
                  </div>
                  <div class="ml-3">
                    <div class="text-sm font-medium text-gray-900">{{ user.first_name }} {{ user.last_name }}</div>
                    <div class="text-xs text-gray-500">{{ formatUserType(user.table_type) }}</div>
                  </div>
                </div>
                <span :class="`inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${getStatusBadgeClass(user.status)}`">
                  <span :class="`w-1.5 h-1.5 rounded-full mr-1 ${getStatusDotClass(user.status)}`"></span>
                  {{getDisplayStatus(user)}}
                </span>
              </div>

              <div class="grid grid-cols-2 gap-2 text-xs text-gray-600 mb-3">
                <div><span class="font-medium">Email:</span> {{ user.email }}</div>
                <div><span class="font-medium">Amount:</span> {{ formatAmount(user.amount) }}</div>
                <div><span class="font-medium">Credit Score:</span>
                  <span :class="`inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium ${user.credit_score >= 700 ? 'bg-green-100 text-green-800' : user.credit_score >= 600 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}`">
                    {{ user.credit_score }}
                  </span>
                </div>
              </div>

              <div class="flex items-center justify-end space-x-2">
                <button @click="goToReport(user)" class="text-gray-400 hover:text-blue-600 p-2 rounded hover:bg-blue-50 transition-colors" title="View Details">
                  <Eye size="16" />
                </button>

                <!-- APPROVE/REJECT BUTTONS -->
                <template v-if="['Pending', 'Approved', 'Rejected'].includes(user.approval_status)">
                  <button @click="approveUser(user)" class="text-gray-400 hover:text-green-600 p-2 rounded hover:bg-green-50 transition-colors" title="Approve">
                    <Check size="16" />
                  </button>
                  <button @click="rejectUser(user)" class="text-gray-400 hover:text-red-600 p-2 rounded hover:bg-red-50 transition-colors" title="Reject">
                    <X size="16" />
                  </button>
                </template>

                <!--  UPDATE BUTTON -->
                <button @click="editUser(user)" class="text-gray-400 hover:text-yellow-600 p-2 rounded hover:bg-yellow-50 transition-colors" title="Edit User">
                  <Pencil size="16" />
                </button>

                <!--  DELETE BUTTON -->
                <button @click="deleteUser(user)" class="text-gray-400 hover:text-red-600 p-2 rounded hover:bg-red-50 transition-colors" title="Delete User">
                  <Trash size="16" />
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Desktop Table View (hidden on small screens) -->
        <div v-else class="hidden sm:block overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50">
            <tr>
              <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <div class="flex items-center">Status <ChevronDown size="16" class="ml-1 text-gray-400" /></div>
              </th>
              <th class="hidden md:table-cell px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <div class="flex items-center">Role <Info size="16" class="ml-1 text-gray-400" /></div>
              </th>
              <th class="hidden lg:table-cell px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th class="hidden xl:table-cell px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
              <th class="hidden lg:table-cell px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credit Score</th>
              <th class="px-3 lg:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="user in filteredUsers" :key="`${user.table_type}-${user.id}`" class="hover:bg-gray-50">
              <!-- Name -->
              <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="h-8 w-8 lg:h-10 lg:w-10 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 flex items-center justify-center text-white font-medium text-xs lg:text-sm">
                    {{ getInitials(user.first_name, user.last_name) }}
                  </div>
                  <div class="ml-2 lg:ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ user.first_name }} {{ user.last_name }}</div>
                    <div class="hidden lg:block text-sm text-gray-500">@{{ user.first_name?.toLowerCase() }}</div>
                  </div>
                </div>
              </td>

              <!-- Status -->
              <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
          <span :class="`inline-flex items-center px-2 py-1 lg:px-2.5 lg:py-0.5 rounded-full text-xs font-medium ${getStatusBadgeClass(user.status)}`">
            <span :class="`w-1.5 h-1.5 rounded-full mr-1 lg:mr-1.5 ${getStatusDotClass(user.status)}`"></span>
            <span class="hidden sm:inline">{{getDisplayStatus(user)}}</span>
            <span class="sm:hidden">{{getDisplayStatus(user).split(' ')[0]}}</span>
          </span>
              </td>

              <!-- Role -->
              <td class="hidden md:table-cell px-3 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatUserType(user.table_type) }}
              </td>

              <!-- Email -->
              <td class="hidden lg:table-cell px-3 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ user.email }}
              </td>

              <!-- Amount -->
              <td class="hidden xl:table-cell px-3 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatAmount(user.amount) }}
              </td>

              <!-- Credit Score -->
              <td class="hidden lg:table-cell px-3 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
          <span :class="`inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${user.credit_score >= 700 ? 'bg-green-100 text-green-800' : user.credit_score >= 600 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}`">
            {{ user.credit_score }}
          </span>
              </td>

              <!-- Actions -->
              <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                <div class="inline-flex items-center justify-center space-x-1 lg:space-x-2">
                  <button @click="goToReport(user)" class="text-gray-400 hover:text-blue-600 p-2 rounded hover:bg-blue-50 transition-colors" title="View Details">
                    <Eye size="16" />
                  </button>

                  <template v-if="['Pending', 'Approved', 'Rejected'].includes(user.approval_status)">
                    <button @click="approveUser(user)" class="text-gray-400 hover:text-green-600 p-1 rounded hover:bg-green-50 transition-colors" title="Approve">
                      <Check size="16" class="lg:w-[18px] lg:h-[18px]" />
                    </button>
                    <button @click="rejectUser(user)" class="text-gray-400 hover:text-red-600 p-1 rounded hover:bg-red-50 transition-colors" title="Reject">
                      <X size="16" class="lg:w-[18px] lg:h-[18px]" />
                    </button>
                  </template>

                  <button @click="editUser(user)" class="text-gray-400 hover:text-yellow-600 p-1 rounded hover:bg-yellow-50 transition-colors" title="Edit User">
                    <Pencil size="16" class="lg:w-[18px] lg:h-[18px]" />
                  </button>

                  <button @click="deleteUser(user)" class="text-gray-400 hover:text-red-600 p-1 rounded hover:bg-red-50 transition-colors" title="Delete User">
                    <Trash size="16" class="lg:w-[18px] lg:h-[18px]" />
                  </button>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination (unchanged) -->
        <div v-if="!loading && !error && users.length > 0 && totalPages > 1" class="px-3 sm:px-6 py-4 border-t border-gray-200">
          <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <button
                @click="() => currentPage = Math.max(currentPage - 1, 1)"
                :disabled="currentPage === 1"
                :class="`flex items-center px-3 py-2 text-sm ${currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:text-gray-700 cursor-pointer'}`"
            >
              <ChevronLeft size="16" class="mr-1" />
              Previous
            </button>

            <div class="flex items-center space-x-1 sm:space-x-2 overflow-x-auto">
              <template v-for="(page, index) in getVisiblePages()" :key="index">
                <button v-if="page !== '...'" @click="currentPage = page"
                        :class="`px-2 sm:px-3 py-2 text-sm font-medium rounded whitespace-nowrap ${page === currentPage ? 'text-indigo-600 bg-indigo-50 cursor-default' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50 cursor-pointer'}`">
                  {{ page }}
                </button>
                <span v-else class="px-1 sm:px-2 text-gray-400">...</span>
              </template>
            </div>

            <button
                @click="currentPage = Math.min(currentPage + 1, totalPages)"
                :disabled="currentPage === totalPages"
                :class="`flex items-center px-3 py-2 text-sm ${currentPage === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:text-gray-700 cursor-pointer'}`"
            >
              Next
              <ChevronRight size="16" class="ml-1" />
            </button>
          </div>

          <div class="mt-3 text-center text-sm text-gray-500">
            Showing {{ startIndex + 1 }} to {{ Math.min(startIndex + usersPerPage, totalUsers) }} of {{ totalUsers }} results
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- View Modal-->
  <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 w-full max-w-lg relative max-h-[90vh] overflow-y-auto">
      <button @click="showModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
        <X size="20" />
      </button>

      <h2 class="text-xl sm:text-2xl font-semibold mb-4">User Details</h2>

      <div v-if="selectedUser" class="space-y-3">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
          <p><strong>Name:</strong> {{ selectedUser.first_name }} {{ selectedUser.last_name }}</p>
          <p><strong>Type:</strong> {{ formatUserType(selectedUser.table_type) }}</p>
          <p class="sm:col-span-2"><strong>Email:</strong> {{ selectedUser.email }}</p>
          <p><strong>Phone:</strong> {{ selectedUser.phone_number || 'N/A' }}</p>
          <p><strong>Status:</strong> {{ selectedUser.status }}</p>
          <p><strong>Amount:</strong> {{ formatAmount(selectedUser.amount) }}</p>
          <p><strong>Credit Score:</strong> {{ selectedUser.credit_score || 'N/A' }}</p>
        </div>
      </div>

      <div class="mt-6 flex justify-end">
        <button @click="showModal = false" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 w-full sm:w-auto">Close</button>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div
      v-if="isEditing"
      class="fixed inset-0 flex items-center justify-center z-50 p-4"
      style="background-color: rgba(0, 0, 0, 0.4); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);"
  >
    <div
        class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg max-h-[90vh] overflow-y-auto relative"
    >
      <button
          @click="isEditing = false"
          class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"
          aria-label="Close"
      >
        <X size="20" />
      </button>

      <h2 class="text-xl sm:text-2xl font-semibold mb-6">Edit User</h2>

      <form @submit.prevent="submitUpdate">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
          <div>
            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">
              First Name
            </label>
            <input
                id="firstName"
                v-model="editForm.first_name"
                type="text"
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>

          <div>
            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">
              Last Name
            </label>
            <input
                id="lastName"
                v-model="editForm.last_name"
                type="text"
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>

          <div class="sm:col-span-2">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
              Email
            </label>
            <input
                id="email"
                v-model="editForm.email"
                type="email"
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>

          <div class="sm:col-span-2">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
              Phone
            </label>
            <input
                id="phone"
                v-model="editForm.phone_number"
                type="tel"
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>

          <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
              Status
            </label>
            <select
                id="status"
                v-model="editForm.status"
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="Active">Active</option>
              <option value="Suspended">Suspended</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

          <div>
            <label for="approvalStatus" class="block text-sm font-medium text-gray-700 mb-1">
              Approval Status
            </label>
            <select
                id="approvalStatus"
                v-model="editForm.approval_status"
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="Pending">Pending</option>
              <option value="Approved">Approved</option>
              <option value="Rejected">Rejected</option>
            </select>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-end gap-2">
          <button
              @click="isEditing = false"
              type="button"
              class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 order-2 sm:order-1"
          >
            Cancel
          </button>
          <button
              type="submit"
              class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 order-1 sm:order-2"
          >
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>

</template>

<script setup>
definePageMeta({
  layout: 'admin',
  middleware: 'admin-auth'
})

import { ref, computed, onMounted, watch } from 'vue';
import { useRouter } from 'vue-router';
import { useNuxtApp } from '#app';
import { Eye, Check, X, ChevronDown, Info, ChevronLeft, ChevronRight, Pencil, Trash } from 'lucide-vue-next';

const { $axios } = useNuxtApp();

const router = useRouter();

const users = ref([]);
const loading = ref(true);
const error = ref(null);
const currentPage = ref(1);
const selectedUsers = ref(new Set());
const statusFilter = ref('all');
const roleFilter = ref('borrower');
const usersPerPage = 10;
const totalUsers = ref(0);
const totalPages = ref(0);
const showModal = ref(false);
const selectedUser = ref(null);
const isEditing = ref(false);
const editForm = ref({});
const searchQuery = ref('');

// Go to report page
const goToReport = (user) => {
  router.push({
    path: '/admin/pages/users/report',
    query: { id: user.id, table_type: user.table_type }
  });
};
const filteredUsers = computed(() => {
  if (!searchQuery.value.trim()) return users.value;
  return users.value.filter(user => {
    const fullName = `${user.first_name} ${user.last_name}`.toLowerCase();
    return fullName.includes(searchQuery.value.trim().toLowerCase());
  });
});

const fetchUsers = async () => {
  loading.value = true;
  error.value = null;

  try {
    const params = new URLSearchParams({
      page: currentPage.value.toString(),
      per_page: usersPerPage.toString(),
      role: roleFilter.value
    });

    if (statusFilter.value !== 'all') {
      params.append('status', statusFilter.value);
    }

    const response = await $axios.get(`/admin/users?${params}`);

    users.value = response.data.users || [];
    totalUsers.value = response.data.total || 0;
    totalPages.value = response.data.total_pages || 0;

  } catch (err) {
    console.error('Fetch error:', err);
    error.value = err.response?.data?.message || 'Failed to fetch users';
    users.value = [];
    totalUsers.value = 0;
    totalPages.value = 0;
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchUsers();
});

watch([currentPage, statusFilter, roleFilter], () => {
  fetchUsers();
});

const startIndex = computed(() => (currentPage.value - 1) * usersPerPage);

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

const editUser = (user) => {
  selectedUser.value = { ...user };
  editForm.value = { ...user };
  isEditing.value = true;
};

const submitUpdate = async () => {
  try {
    const response = await $axios.put(`/admin/users/${editForm.value.table_type}/${editForm.value.id}`, editForm.value);

    updateUserInList(response.data.user);
    isEditing.value = false;
    alert('User updated!');
  } catch (err) {
    alert(err.response?.data?.message || 'Update failed');
  }
};

const updateUserInList = (updatedUser) => {
  const index = users.value.findIndex(u => u.id === updatedUser.id && u.table_type === updatedUser.table_type);
  if (index !== -1) {
    users.value[index] = updatedUser;
  }
};

const viewUser = async (user) => {
  try {
    const response = await $axios.get(`/admin/users/${user.table_type}/${user.id}`);

    if (!response.data.user) throw new Error('User data missing in response');

    selectedUser.value = response.data.user;
    showModal.value = true;

  } catch (err) {
    console.error('Error viewing user:', err);
    alert(err.response?.data?.message || 'Failed to fetch user details');
  }
};

const approveUser = async (user) => {
  if (!confirm(`Are you sure you want to approve ${user.first_name} ${user.last_name}?`)) return;

  try {
    const response = await $axios.post(`/admin/users/${user.table_type}/${user.id}/approve`);

    const userIndex = users.value.findIndex(u => u.id === user.id && u.table_type === user.table_type);
    if (userIndex !== -1) {
      users.value[userIndex].status = response.data.user.status;
      users.value[userIndex].approval_status = response.data.user.approval_status;
    }

    alert(`${user.first_name} ${user.last_name} has been approved!`);
  } catch (err) {
    console.error('Error approving user:', err);
    alert(err.response?.data?.message || 'Failed to approve user');
  }
};

const rejectUser = async (user) => {
  if (!confirm(`Are you sure you want to reject ${user.first_name} ${user.last_name}?`)) return;

  try {
    const response = await $axios.post(`/admin/users/${user.table_type}/${user.id}/reject`);

    const userIndex = users.value.findIndex(u => u.id === user.id && u.table_type === user.table_type);
    if (userIndex !== -1) {
      users.value[userIndex].status = response.data.user.status;
      users.value[userIndex].approval_status = response.data.user.approval_status;
    }

    alert(`${user.first_name} ${user.last_name} has been rejected.`);
  } catch (err) {
    console.error('Error rejecting user:', err);
    alert(err.response?.data?.message || 'Failed to reject user');
  }
};

const deleteUser = async (user) => {
  if (!confirm(`Are you sure you want to delete ${user.first_name} ${user.last_name}?`)) return;

  try {
    const response = await $axios.delete(`/admin/users/${user.table_type}/${user.id}`, { data: { table_type: user.table_type } });

    users.value = users.value.filter(u => !(u.id === user.id && u.table_type === user.table_type));
    alert(response.data.message);
  } catch (err) {
    alert(err.response?.data?.message || 'Delete failed');
  }
};

const handleSelectUser = (userId) => {
  if (selectedUsers.value.has(userId)) {
    selectedUsers.value.delete(userId);
  } else {
    selectedUsers.value.add(userId);
  }
};

const handleSelectAll = () => {
  if (selectedUsers.value.size === users.value.length) {
    selectedUsers.value = new Set();
  } else {
    selectedUsers.value = new Set(users.value.map(user => `${user.table_type}-${user.id}`));
  }
};

const getDisplayStatus = (user) => {
  // If suspended, always show status (which is "Suspended")
  if (user.status === 'Suspended') return user.status;
  if (user.status === 'Inactive') return user.status;

  if (user.approval_status === 'Pending') return 'Pending';
  if (user.approval_status === 'Approved' && user.status !== 'Active') return 'Approved';
  if (user.approval_status === 'Rejected') return 'Rejected';

  return user.status || 'Inactive';
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
  return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount);
};

const getVisiblePages = () => {
  const pages = [];
  const total = totalPages.value;
  const current = currentPage.value;

  if (total <= 1) return pages;

  pages.push(1);

  if (total <= 7) {
    for (let i = 2; i <= total; i++) {
      pages.push(i);
    }
  } else {
    if (current <= 4) {
      for (let i = 2; i <= 5; i++) {
        pages.push(i);
      }
      pages.push('...');
      pages.push(total);
    } else if (current >= total - 3) {
      pages.push('...');
      for (let i = total - 4; i <= total; i++) {
        pages.push(i);
      }
    } else {
      pages.push('...');
      for (let i = current - 1; i <= current + 1; i++) {
        pages.push(i);
      }
      pages.push('...');
      pages.push(total);
    }
  }

  return pages;
};
</script>

<template>
  <div class="min-h-screen bg-gray-100 p-4 sm:p-8 font-sans">
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
      <!-- Tab Navigation -->
      <div class="flex flex-wrap border-b border-gray-200 text-sm sm:text-base">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          :class="[
            'px-4 py-3 sm:px-6 sm:py-4 font-medium transition-colors duration-200 ease-in-out',
            activeTab === tab.id
              ? 'text-blue-600 border-b-2 border-blue-600'
              : 'text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-300'
          ]"
        >
          {{ tab.name }}
        </button>
      </div>

      <!-- Table Container -->
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th
                v-for="header in tableHeaders"
                :key="header.key"
                scope="col"
                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap sm:px-6"
              >
                {{ header.label }}
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr
              v-for="item in filteredTableData"
              :key="item.borrowerShort"
              :class="item.status === 'Late' ? 'bg-red-50' : ''"
            >
              <td class="px-4 py-3 sm:px-6 whitespace-nowrap">
                <div class="flex items-center">
                  <div
                    :class="[
                      'flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm',
                      item.status === 'Late' ? 'bg-red-500' : 'bg-blue-500'
                    ]"
                  >
                    {{ item.borrowerShort }}
                  </div>
                  <div class="ml-3 text-sm font-medium text-gray-900">
                    {{ item.borrower }}
                  </div>
                </div>
              </td>
              <td class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900">
                {{ item.amount }}
              </td>
              <td class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900">
                {{ item.interestRate }}
              </td>
              <td class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900">
                {{ item.term }}
              </td>
              <td class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900">
                {{ item.startDate }}
              </td>
              <td class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900">
                {{ item.dueDate }}
              </td>
              <td class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900">
                {{ item.total }}
              </td>
              <td class="px-4 py-3 sm:px-6 whitespace-nowrap text-sm text-gray-900">
                <span
                  :class="[
                    'px-3 py-1 rounded-full text-xs font-semibold',
                    item.status === 'Active'
                      ? 'bg-green-100 text-green-800'
                      : item.status === 'Completed'
                      ? 'bg-blue-100 text-blue-800'
                      : 'bg-red-100 text-red-800'
                  ]"
                >
                  {{ item.status === 'Late' ? `${item.status} (${item.lateDays})` : item.status }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const tabs = ref([
  { id: 'all', name: 'All fund' },
  { id: 'active', name: 'Active' },
  { id: 'completed', name: 'Completed' },
  { id: 'late', name: 'Late' }
]);

const activeTab = ref('all');

const tableHeaders = ref([
  { key: 'borrower', label: 'Borrower' },
  { key: 'amount', label: 'Amount' },
  { key: 'interestRate', label: 'Interest Rate' },
  { key: 'term', label: 'Term' },
  { key: 'startDate', label: 'Start Date' },
  { key: 'dueDate', label: 'Due Date' },
  { key: 'total', label: 'Total' },
  { key: 'status', label: 'Status' }
]);

const tableData = ref([
  {
    borrowerShort: 'JD',
    borrower: 'John Doe',
    amount: '$ 1,500',
    interestRate: '5.2 %',
    term: '1 months',
    startDate: 'May 15, 2025',
    dueDate: 'Jun 15, 2025',
    total: '$ 1,600',
    status: 'Active',
    lateDays: ''
  },
  {
    borrowerShort: 'SJ',
    borrower: 'Sarah Johnson',
    amount: '$ 1,500',
    interestRate: '6.8 %',
    term: '1 months',
    startDate: 'May 12, 2025',
    dueDate: 'Jun 12, 2025',
    total: '$ 1,600',
    status: 'Active',
    lateDays: ''
  },
  {
    borrowerShort: 'MT',
    borrower: 'Michael Torres',
    amount: '$ 2,500',
    interestRate: '4.9 %',
    term: '1 months',
    startDate: 'Apr 10, 2025',
    dueDate: 'May 10, 2025',
    total: '$ 2,480',
    status: 'Late',
    lateDays: '5 days'
  },
  {
    borrowerShort: 'AK',
    borrower: 'Aisha Khan',
    amount: '$ 1,000',
    interestRate: '8.5 %',
    term: '1 months',
    startDate: 'May 05, 2025',
    dueDate: 'Jun 05, 2025',
    total: '$ 1,150',
    status: 'Active', // Assuming this is active based on the image, though no explicit status is given
    lateDays: ''
  },
  {
    borrowerShort: 'RL',
    borrower: 'Robert Lee',
    amount: '$ 2,000',
    interestRate: '5.8 %',
    term: '1 months',
    startDate: 'Apr 9, 2023',
    dueDate: 'May 9, 2025',
    total: '$ 2,100',
    status: 'Completed',
    lateDays: ''
  },
  {
    borrowerShort: 'EW',
    borrower: 'Emma Wilson',
    amount: '$ 500',
    interestRate: '7.2 %',
    term: '1 months',
    startDate: 'May 12, 2022',
    dueDate: 'Jun 12, 2025',
    total: '$ 650',
    status: 'Active',
    lateDays: ''
  }
]);

const filteredTableData = computed(() => {
  if (activeTab.value === 'all') {
    return tableData.value;
  }
  return tableData.value.filter(item => {
    if (activeTab.value === 'late') {
      return item.status === 'Late';
    }
    return item.status.toLowerCase() === activeTab.value;
  });
});
</script>

<style scoped>
/* No custom CSS needed as Tailwind handles everything */
</style>

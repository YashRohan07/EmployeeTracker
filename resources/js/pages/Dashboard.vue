<script setup>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import { Head, router, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = usePage().props
const { employeeCount, departmentCount, recentEmployees, allEmployees, departments, filters } = props

const search = ref(filters.search || '')
const selectedDepartment = ref(filters.department_id || '')
const salaryMin = ref(filters.salary_min || '')
const salaryMax = ref(filters.salary_max || '')
const sortOrder = ref(filters.sort || 'asc')
const joiningDateFrom = ref(filters.joining_date_from || '')
const joiningDateTo = ref(filters.joining_date_to || '')

const applyFilters = () => {
  router.get('/dashboard', {
    search: search.value,
    department_id: selectedDepartment.value,
    salary_min: salaryMin.value,
    salary_max: salaryMax.value,
    sort: sortOrder.value,
    joining_date_from: joiningDateFrom.value,
    joining_date_to: joiningDateTo.value,
  })
}

const editEmployee = (id) => {
  router.visit(`/employees/${id}/edit`)
}

const deleteEmployee = (id) => {
  if (!confirm('Are you sure you want to delete this employee?')) return

  router.delete(`/api/employees/${id}`, {
    onSuccess: () => {
      alert('Employee deleted successfully!')
      applyFilters() // refresh list after delete
    },
    onError: () => {
      alert('Failed to delete employee.')
    }
  })
}
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

        <!-- Metrics -->
        <div class="grid grid-cols-2 gap-6 mb-6">
          <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold">Employees</h3>
            <p class="text-3xl font-bold">{{ employeeCount }}</p>
          </div>
          <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold">Departments</h3>
            <p class="text-3xl font-bold">{{ departmentCount }}</p>
          </div>
        </div>

        <!-- All Employees + Filters -->
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6 mb-6">
          <h3 class="text-lg font-semibold mb-4">All Employees</h3>

          <!-- Filters -->
          <div class="flex flex-wrap gap-4 mb-4">
            <input v-model="search" type="text" placeholder="Search name or email" class="border p-2" />
            <select v-model="selectedDepartment" class="border p-2">
              <option value="">All Departments</option>
              <option v-for="dept in departments" :key="dept.id" :value="dept.id">
                {{ dept.name }}
              </option>
            </select>
            <input v-model="salaryMin" type="number" placeholder="Min Salary" class="border p-2" />
            <input v-model="salaryMax" type="number" placeholder="Max Salary" class="border p-2" />
            <input v-model="joiningDateFrom" type="date" class="border p-2" />
            <input v-model="joiningDateTo" type="date" class="border p-2" />
            <select v-model="sortOrder" class="border p-2">
              <option value="asc">Sort Asc</option>
              <option value="desc">Sort Desc</option>
            </select>
            <button @click="applyFilters" class="px-4 py-2 bg-blue-600 text-white rounded">
              Apply
            </button>
          </div>

          <!-- Employee Table -->
          <table class="min-w-full border">
            <thead>
              <tr class="bg-gray-200">
                <th class="p-2 text-left">Name</th>
                <th class="p-2 text-left">Email</th>
                <th class="p-2 text-left">Department</th>
                <th class="p-2 text-left">Salary</th>
                <th class="p-2 text-left">Joining Date</th>
                <th class="p-2 text-left">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="emp in allEmployees.data" :key="emp.id" class="border-b">
                <td class="p-2">{{ emp.name }}</td>
                <td class="p-2">{{ emp.email }}</td>
                <td class="p-2">{{ emp.department?.name }}</td>
                <td class="p-2">
                  {{ emp.detail?.salary ? `$${emp.detail.salary.toLocaleString()}` : 'N/A' }}
                </td>
                <td class="p-2">
                  {{
                    emp.detail?.joined_date
                      ? new Date(emp.detail.joined_date).toLocaleDateString()
                      : 'N/A'
                  }}
                </td>
                <td class="p-2 flex gap-2">
                  <button
                    @click="editEmployee(emp.id)"
                    class="px-2 py-1 bg-blue-600 text-white rounded"
                  >
                    Edit
                  </button>
                  <button
                    @click="deleteEmployee(emp.id)"
                    class="px-2 py-1 bg-red-600 text-white rounded"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Pagination -->
          <div class="mt-4 flex gap-2">
            <button
              v-for="link in allEmployees.links"
              :key="link.label"
              :disabled="!link.url"
              @click="router.visit(link.url)"
              v-html="link.label"
              class="px-3 py-1 border"
            ></button>
          </div>
        </div>

        <!-- Recent -->
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
          <h3 class="text-lg font-semibold mb-4">Recent Employees</h3>
          <table class="min-w-full border">
            <thead>
              <tr class="bg-gray-200">
                <th class="p-2 text-left">Name</th>
                <th class="p-2 text-left">Department</th>
                <th class="p-2 text-left">Salary</th>
                <th class="p-2 text-left">Joining Date</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="emp in recentEmployees" :key="emp.id" class="border-b">
                <td class="p-2">{{ emp.name }}</td>
                <td class="p-2">{{ emp.department?.name || 'No Department' }}</td>
                <td class="p-2">
                  {{ emp.detail?.salary ? `$${emp.detail.salary.toLocaleString()}` : 'N/A' }}
                </td>
                <td class="p-2">
                  {{
                    emp.detail?.joined_date
                      ? new Date(emp.detail.joined_date).toLocaleDateString()
                      : 'N/A'
                  }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

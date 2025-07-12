<script setup>
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import axios from 'axios'

const props = defineProps({
  employee: {
    type: Object,
    default: null
  }
})

const form = useForm({
  name: '',
  email: '',
  department_id: '',
  designation: '',
  salary: '',
  address: '',
  joined_date: '',
})

const departments = ref([])

const fetchDepartments = async () => {
  const res = await axios.get('/api/departments')
  departments.value = res.data
}

onMounted(() => {
  fetchDepartments()
  if (props.employee) {
    form.name = props.employee.name
    form.email = props.employee.email
    form.department_id = props.employee.department?.id
    form.designation = props.employee.detail?.designation
    form.salary = props.employee.detail?.salary
    form.address = props.employee.detail?.address
    form.joined_date = props.employee.detail?.joined_date
  }
})

const submit = () => {
  if (props.employee) {
    axios.put(`/api/employees/${props.employee.id}`, form)
      .then(() => alert('Employee updated successfully!'))
      .catch(err => console.log(err.response?.data))
  } else {
    axios.post('/api/employees', form)
      .then(() => {
        alert('Employee created successfully!')
        form.reset()
      })
      .catch(err => console.log(err.response?.data))
  }
}
</script>

<template>
  <div class="p-6 max-w-xl mx-auto">
    <h2 class="text-xl font-bold mb-4">
      {{ employee ? 'Edit Employee' : 'Create Employee' }}
    </h2>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block font-medium">Name</label>
        <input v-model="form.name" type="text" class="border p-2 w-full" required />
      </div>

      <div>
        <label class="block font-medium">Email</label>
        <input v-model="form.email" type="email" class="border p-2 w-full" required />
      </div>

      <div>
        <label class="block font-medium">Department</label>
        <select v-model="form.department_id" class="border p-2 w-full" required>
          <option value="">Select</option>
          <option v-for="dept in departments" :key="dept.id" :value="dept.id">
            {{ dept.name }}
          </option>
        </select>
      </div>

      <div>
        <label class="block font-medium">Designation</label>
        <input v-model="form.designation" type="text" class="border p-2 w-full" required />
      </div>

      <div>
        <label class="block font-medium">Salary</label>
        <input v-model="form.salary" type="number" class="border p-2 w-full" required />
      </div>

      <div>
        <label class="block font-medium">Address</label>
        <input v-model="form.address" type="text" class="border p-2 w-full" required />
      </div>

      <div>
        <label class="block font-medium">Joined Date</label>
        <input v-model="form.joined_date" type="date" class="border p-2 w-full" required />
      </div>

      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
        {{ employee ? 'Update' : 'Create' }}
      </button>
    </form>
  </div>
</template>

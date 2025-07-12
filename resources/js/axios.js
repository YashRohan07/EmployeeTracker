import axios from 'axios'

const apiAxios = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost/EmployeeTracker/public/api',
  withCredentials: true,
  headers: {
    Accept: 'application/json',
  },
})

// Optional: Add token if you want in the future
// const token = localStorage.getItem('auth_token')
// if (token) {
//   apiAxios.defaults.headers.common['Authorization'] = `Bearer ${token}`
// }

export default apiAxios

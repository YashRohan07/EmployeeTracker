import axios from 'axios'

const csrfAxios = axios.create({
  baseURL: 'http://localhost/EmployeeTracker/public', // no /api here
  withCredentials: true,
  headers: {
    Accept: 'application/json',
  },
})

export default csrfAxios

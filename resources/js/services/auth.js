import axios from '../axios'

export async function login(email, password) {
  // STEP 1 — Get CSRF cookie
  await axios.get('/sanctum/csrf-cookie')

  // STEP 2 — Send login
  const res = await axios.post('/login', {
    email,
    password
  })

  return res.data
}

import {createRouter, createWebHistory} from 'vue-router'

import store from '../store'


const Index = () => import('../pages/index.vue')
const LoginPage = () => import('../pages/login.vue')
const RegisterPage = () => import('../pages/signup.vue')


const routes = [
  { path: '/', name: 'index', component: Index },
  { path: '/login', name: 'login', component: LoginPage },
  { path: '/register', name: 'register', component: RegisterPage },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

//create middleware if not login redirect to login page
router.beforeEach((to, from, next) => {
  // Daftar halaman yang diizinkan untuk diakses tanpa login
  const allowedPages = ['login', 'register'];

  if (!allowedPages.includes(to.name) && !store.getters.isAuthenticated) {
    // Jika bukan halaman yang diizinkan dan pengguna tidak terotentikasi,
    // arahkan ke halaman login
    next({ name: 'login' });
  } else {
    // Halaman diizinkan atau pengguna sudah terotentikasi, lanjutkan
    next();
  }
});

export default router;
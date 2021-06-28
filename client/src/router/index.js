import { createRouter, createWebHistory } from 'vue-router'

const isLoggedIn = localStorage.getItem('isLoggedIn')

const routes = [
  {
    path: '/',
    name: 'Home',
    redirect: isLoggedIn ? '' : '/login',
    component: () => import('@/views/Home.vue')
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  },
  {
    path: '/exchange_token',
    component: () => import('@/views/Auth/Strava')
  },
  {
    path: '/login',
    redirect: isLoggedIn ? '/' : '',
    component: () => import('@/views/Auth/Login.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router

import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Cart from '../views/Cart.vue'
import Register from '../views/Register.vue'
import Login from '../views/Login.vue'
import Thanks from '../views/Thanks.vue'

import store from '../store'


const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/about',
    name: 'About',
  },
  {
    path: '/cart',
    name: 'Cart',
    component: Cart,
    meta: { requiresAuth: true }
  },
  {
    path: '/signup',
    name: 'Signup',
    component: Register
  },
  {
    path: '/thanks',
    name: 'thanks',
    component: Thanks,
    beforeEnter: (to, from, next) => {
      if(from.name !== 'Cart') next({ name: 'Cart' })
      else next()
    }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
]


const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.isAuth) next({ name: 'Login' })
  else next()

  if (!from.name === 'Cart' && to.name === 'Thanks') next({ name: 'Cart' })
  else next()
})

export default router

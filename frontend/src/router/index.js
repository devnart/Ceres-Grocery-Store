import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import Cart from "../views/Cart.vue";
import Login from "../views/Login.vue";
import Thanks from "../views/Thanks.vue";
import Profile from "../views/Profile.vue";
import Dashboard from "../views/Dashboard.vue";
import Order from "../views/Order.vue";
import User from "../views/User.vue";

import store from "../store";

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/about",
    name: "About",
  },
  {
    path: "/cart",
    name: "Cart",
    component: Cart,
    meta: { requiresAuth: true },
  },
  {
    path: "/thanks",
    name: "thanks",
    component: Thanks,
    beforeEnter: (to, from, next) => {
      if (from.name !== "Cart") next({ name: "Cart" });
      else next();
    },
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
    beforeEnter: (to, from, next) => {
      if (store.state.isAuth) next({ name: "Home" });
      else next();
    },
  },
  {
    path: "/profile",
    name: "Profile",
    component: Profile,
    meta: { requiresAuth: true, template: "user" },
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAuth: false, template: "admin" },
  },
  {
    path: "/order/:id",
    name: "Order",
    component: Order,
    meta: { requiresAuth: false, template: "admin" },
    
  },
  {
    path: "/users/:id",
    name: "User",
    component: User,
    meta: { requiresAuth: false, template: "admin" },

  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.isAuth) next({ name: "Login" });
  if (to.meta.template == 'admin'){
    store.commit('SET_LAYOUT', 'admin-layout')
    next()
  } else if (to.meta.template == 'user'){
    store.commit('SET_LAYOUT', 'user-layout')
    next()

  } else {
    next();}
    

  if (!from.name === "Cart" && to.name === "Thanks") next({ name: "Home" });
});

export default router;

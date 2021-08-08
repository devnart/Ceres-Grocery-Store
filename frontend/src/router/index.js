import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import Cart from "../views/Cart.vue";
import Login from "../views/Login.vue";
import Thanks from "../views/Thanks.vue";
import Profile from "../views/Profile.vue";
import AdminLogin from "../views/AdminLogin.vue";
import Dashboard from "../views/Dashboard.vue";
import Order from "../views/Order.vue";
import Orders from "../views/Orders.vue";
import Users from "../views/Users.vue";
import User from "../views/User.vue";
import Products from "../views/Products.vue";
import AddProducts from "../views/AddProducts.vue";

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
    path: "/dashboard/login",
    name: "AdminLogin",
    component: AdminLogin,
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAdmin: true, template: "admin" },
  },
  {
    path: "/orders/:id",
    name: "Order",
    component: Order,
    meta: { requiresAdmin: true, template: "admin" },
  },
  {
    path: "/orders",
    name: "Orders",
    alias: "/orders/page/1",
    component: Orders,
    meta: { requiresAdmin: true, template: "admin" },
  },
  {
    path: "/orders/page/:number",
    name: "Orders List",
    component: Orders,
    meta: { requiresAdmin: true, template: "admin" },
  },
  {
    path: "/products",
    name: "Products",
    // alias: '/users/page/1',
    component: Products,
    meta: { requiresAdmin: true, template: "admin" },
  },
  {
    path: "/products/add",
    name: "Add Products",
    component: AddProducts,
    meta: { requiresAdmin: true, template: "admin" },
  },
  {
    path: "/users",
    name: "Users",
    alias: "/users/page/1",
    component: Users,
    meta: { requiresAdmin: true, template: "admin" },
  },
  {
    path: "/users/page/:number",
    name: "Users List",
    component: Users,
    meta: { requiresAdmin: true, template: "admin" },
  },
  {
    path: "/users/:id",
    name: "User",
    component: User,
    meta: { requiresAdmin: true, template: "admin" },
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {

  if (to.meta.requiresAdmin && !store.state.isAdmin) next({ name: "AdminLogin" });


  if (to.meta.requiresAuth && !store.state.isAuth) next({ name: "Login" });
  if (to.meta.template == "admin") {
    store.commit("SET_LAYOUT", "admin-layout");
    
    next();
  } else if (to.meta.template == "user") {
    store.commit("SET_LAYOUT", "user-layout");
    next();
  } else {
    next();
  }
  if (!from.name === "Cart" && to.name === "Thanks") next({ name: "Home" });

});

export default router;

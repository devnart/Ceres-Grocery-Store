import { createRouter, createWebHistory } from "vue-router";

import Home from "../views/Home.vue";
import Discover from "../views/Discover.vue";
import Category from "../views/Category.vue";
import Contact from "../views/Contact.vue";
import About from "../views/About.vue";
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
import EditProduct from "../views/EditProduct.vue";
import NotFound from "../views/NotFound.vue";

import store from "../store";

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
    meta: {
      title: "Ceres - Food service that delivers freshly",
    },
    beforeEnter: (to, from, next) => {
      if (store.state.products.length === 0) {
        store.dispatch("getProducts").then(next);
      } else {
        next();
      }
    },
  },
  {
    path: "/about",
    name: "About",
    component: About,
    meta: {
      title: "About Us",
    },
  },
  {
    path: "/discover",
    name: "Discover",
    component: Discover,
    meta: {
      title: "Discover",
    },
  },
  {
    path: "/contact",
    name: "Contact",
    component: Contact,
    meta: {
      title: "Contact Us",
    },
  },
  {
    path: "/discover/:category",
    name: "Category",
    component: Category,
    meta: {
      title: "Category - Discover",
    },
  },
  {
    path: "/cart",
    name: "Cart",
    component: Cart,
    meta: { requiresAuth: true, title: "Cart" },
    beforeEnter: (to, from, next) => {
      if (store.state.cart == "") next({ name: "Home" });
      else next();
    },
  },
  {
    path: "/thanks",
    name: "thanks",
    props: true,
    component: Thanks,
    meta: { requiresAuth: true, title: "Thanks" },
    beforeEnter: (to, from, next) => {
      if (from.name !== "Cart") next({ name: "Home" });
      else next();
    },
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
    meta: { title: "Login" },
    beforeEnter: (to, from, next) => {
      if (store.state.isAuth) next({ name: "Home" });
      else next();
    },
  },
  {
    path: "/profile",
    name: "Profile",
    component: Profile,

    meta: { requiresAuth: true, title: "Profile", template: "user" },
  },
  {
    path: "/dashboard/login",
    name: "AdminLogin",
    component: AdminLogin,
    meta: { title: "Admin Login" },
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAdmin: false, title: "Dashboard", template: "admin" },
  },
  {
    path: "/orders/:id",
    name: "Order",
    component: Order,
    meta: { requiresAdmin: false, title: "Order", template: "admin" },
  },
  {
    path: "/orders",
    name: "Orders",
    alias: "/orders/page/1",
    component: Orders,
    meta: { requiresAdmin: false, title: "Orders", template: "admin" },
  },
  {
    path: "/orders/page/:number",
    name: "Orders List",
    component: Orders,
    meta: { requiresAdmin: false, title: "Orders", template: "admin" },
  },
  {
    path: "/products",
    name: "Products",
    alias: "/products/page/1",
    component: Products,
    meta: { requiresAdmin: false, title: "Products", template: "admin" },
  },
  {
    path: "/products/page/:number",
    name: "Products List",
    component: Products,
    meta: { requiresAdmin: true, title: "Products", template: "admin" },
  },
  {
    path: "/products/add",
    name: "Add Products",
    component: AddProducts,
    meta: { requiresAdmin: true, title: "Add Product", template: "admin" },
  },
  {
    path: "/products/edit/:id",
    name: "Edit Products",
    component: EditProduct,
    props: true,
    meta: { requiresAdmin: true, title: "Edit Product", template: "admin" },
  },
  {
    path: "/users",
    name: "Users",
    alias: "/users/page/1",
    component: Users,
    meta: { requiresAdmin: true, title: "Users", template: "admin" },
  },
  {
    path: "/users/page/:number",
    name: "Users List",
    component: Users,
    meta: { requiresAdmin: true, title: "Users", template: "admin" },
  },
  {
    path: "/users/:id",
    name: "User",
    component: User,
    meta: { requiresAdmin: true, title: "User", template: "admin" },
  },
  {
    path: "/404",
    name: "NotFound",
    component: NotFound,
    meta: { title: "404" },
  },
  {
    path: "/:catchAll(.*)",
    redirect: "404",
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAdmin && !store.state.isAdmin)
    next({ name: "AdminLogin" });
  if (to.meta.requiresAdmin) {
    store.dispatch("checkAdminJWT");
  }

  if (to.meta.requiresAuth && !store.state.isAuth) next({ name: "Login" });
  if (to.meta.template == "admin") {
    store.commit("SET_LAYOUT", "admin-layout");

    next();
  } else {
    store.commit("SET_LAYOUT", "user-layout");

    next();
  }

  // if (!from.name === "Cart" && to.name === "Thanks") next({ name: "Home" });
});

export default router;

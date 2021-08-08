import { createStore } from "vuex";
import router from "../router";

import axios from "axios";
import createPersistedState from "vuex-persistedstate";
import { createToast } from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";

export default createStore({
  plugins: [
    createPersistedState({
      reducer: (persistedState) => {
        const stateFilter = Object.assign({}, persistedState);
        const blackList = ["layout"];

        blackList.forEach((item) => {
          delete stateFilter[item];
        });

        return stateFilter;
      },
    }),
  ],
  state: {
    products: [],
    cart: [],
    isAuth: JSON.parse(localStorage.getItem("isAuth")) ?? false,
    user: {},
    admin: {},
    layout: "user-layout",
    isAdmin: JSON.parse(localStorage.getItem("isAdmin")) ?? false,
  },
  mutations: {
    SET_PRODUCTS(state, products) {
      state.products = products;
    },
    SET_CART(state, product) {
      state.cart.push(product);
    },
    // empty cart
    CLEAR_CART(state) {
      state.cart = [];
    },

    REMOVE_CART(state, product) {
      state.cart.splice(state.cart.indexOf(product), 1);
    },

    SET_ADMIN_AUTH(state) {
      state.isAdmin = true;
      localStorage.setItem("isAdmin", true);
    },
    UNSET_ADMIN_AUTH(state) {
      state.isAdmin = false;
      localStorage.setItem("isAdmin", false);
    },
    SET_ADMIN(state, admin) {
      state.admin = admin;
    },

    SET_AUTH(state, status) {
      console.log(status);
      state.isAuth = status;
      localStorage.setItem("isAuth", status);
      console.log(state.isAuth);
    },
    SET_USER(state, user) {
      state.user = user;
    },
    SET_LAYOUT(state, payload) {
      state.layout = payload;
    },
  },
  actions: {
    // admin login
    admin_login({ commit }, payload) {
      commit("SET_ADMIN_AUTH");
      commit("SET_ADMIN", payload);
      router.push("/dashboard");
    },

    // admin logout
    admin_logout({ commit }) {
      commit("UNSET_ADMIN_AUTH");
      commit("SET_ADMIN", {});
      router.push("/dashboard/login");
    },
    checkJWT({ commit }) {
      axios
        .post("http://localhost/ceres/backend/UserController/checkToken", {
          token: localStorage.getItem("token"),
        })
        .then((response) => {
          if (response.data != "valid") {
            localStorage.removeItem("isAuth");
            commit("SET_AUTH", false);

            router.push("/login");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // Get Products

    getProducts({ commit }) {
      axios
        .get("http://localhost/ceres/backend/productController/getProducts/")
        .then((response) => {
          commit("SET_PRODUCTS", response.data);
        });
    },

    addToCart({ commit }, payload) {
      if (payload.qty > 0) {
        createToast("Item added successfully", {
          showIcon: true,
          swipeClose: true,
          position: "bottom-center",
          type: "success",
          transition: "slide",
          timeout: 3000,
        });

        commit("SET_CART", payload.product);
      } else {
        createToast("Quantity must be more than 1kg", {
          showIcon: true,
          swipeClose: true,
          position: "bottom-center",
          type: "danger",
          transition: "slide",
          timeout: 3000,
        });
      }
    },
    login({ commit }) {
      commit("SET_AUTH", true);
    },
    logout({ commit }) {
      localStorage.removeItem("isAuth");
      commit("SET_AUTH", false);

    },
  },
  modules: {},
  getters: {
    layout(state) {
      return state.layout;
    },
  },
});

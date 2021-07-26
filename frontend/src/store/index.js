import { createStore } from "vuex";
import axios from "axios";

import { createToast } from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";


export default createStore({
  state: {
    products: [],
    cart: [],
    isAuth: localStorage.getItem('isAuth')
  },
  mutations: {
    SET_PRODUCTS(state, products) {
      state.products = products;

    },
    SET_CART(state, product) {
      state.cart.push(product);
      localStorage.setItem("items", JSON.stringify(state.cart));

    },
    SET_AUTH(state,status){
      state.isAuth = status
      localStorage.setItem("isAuth", status);
    }
  },
  actions: {
    // Get Products

    getProducts({ commit }) {
      axios
        .get("http://localhost/ceres/backend/productController/getProducts/")
        .then((response) => {
          commit("SET_PRODUCTS", response.data);
        });
    },

    addToCart({ commit }, payload) {
      console.log(payload.product, payload.qty);
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
    login({ commit }, payload) {
      commit("SET_AUTH", payload);
    }
  },
  modules: {},
});

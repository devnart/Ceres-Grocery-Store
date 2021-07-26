<template>
  <div id="nav" class="container" v-if="this.$route.name != 'Login'">
    <div class="logo">
      <router-link to="/"
        ><img src="@/assets/img/logo.png" alt="Ceres"
      /></router-link>
    </div>
    <div>
      <ul>
        <li><router-link to="/">Home</router-link></li>
        <li><router-link to="/discover">Discover</router-link></li>
        <li><router-link to="/about">About Us</router-link></li>
        <li><router-link to="/blog">Blog</router-link></li>
      </ul>
    </div>
    <div class="getstarted">
      <router-link
        class="cart"
        :class="{ hasItem: hasItems }"
        @click="checkCart"
        to="#"
        ><img
          class="shopping-cart"
          src="@/assets/img/icons/shopping-cart.svg"
          alt=""
      /></router-link>
      <Button to="signup" text="Get Started" v-if="!$store.state.isAuth" />
    </div>
  </div>
  <router-view />
</template>
<script>
import Button from "@/components/Button.vue";

import { createToast } from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";

export default {
  components: {
    Button,
  },
  data() {
    return {
      hasItems: false,
    };
  },
  methods: {
    checkCart: function (e) {
      e.preventDefault();

      if (
        JSON.parse(localStorage.getItem("items")) == "" ||
        localStorage.getItem("items") == null
      ) {
        createToast("Cart is Empty!", {
          showIcon: "true",
          swipeClose: "true",
          position: "bottom-center",
          type: "danger",
          transition: "slide",
          timeout: 4000,
        });
      } else {
        this.$router.push("/cart");
      }
    },
  },
  mounted() {
    console.log(this.hasItems);
    if (localStorage.getItem("items") != null) {
      if (localStorage.getItem("items").length > 3) {
        this.hasItems = true;
      }
    }

    console.log(this.hasItems);
  },
};
</script>


<style lang="scss">
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap");
@import url("../src/assets/fonts/recoleta/stylesheet.css");

$primary: #3ed749;


// Inputs
input:required:focus:valid {
  outline: 2px solid $primary;
  background: url(~@/assets/img/icons/check.svg) no-repeat 97% 50%
    rgba($color: $primary, $alpha: 0.05);
  background-size: 25px;
}

input:required:focus:invalid {
  outline: 2px solid #fc573b;
  background: url(~@/assets/img/icons/close.svg) no-repeat 97% 50%
    rgba($color: #fc573b, $alpha: 0.05);
  background-size: 25px;
}

$primary: #3ed749;
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
#app {
  font-family: "Poppins", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #4e4e4e;
}
.cart.hasItem {
  margin-right: 10px;
}
.cart.hasItem::after {
  content: "";
  display: block;
  height: 15px;
  width: 15px;
  background: red;
  position: absolute;
  top: -5px;
  right: 0;
  -moz-border-radius: 7.5px;
  -webkit-border-radius: 7.5px;
  border-radius: 7.5px;
}
img {
  width: 100%;
}
.container {
  max-width: 1140px;
  margin: 0 auto;
}
#nav {
  padding: 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  .logo {
    width: 140px;
  }
  ul {
    display: flex;
    gap: 20px;
    li {
      list-style: none;
    }
  }
  a {
    color: #8d8d8d;
    text-decoration: none;

    &.router-link-exact-active {
      color: $primary;
    }
  }
}
.getstarted {
  display: flex;
  align-items: center;
  a {
    position: relative;
  }
  img {
    width: 30px;
    margin-right: 10px;
  }
}
</style>

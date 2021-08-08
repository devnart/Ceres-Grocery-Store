<template>
  <div id="nav" class="container" v-if="this.$route.name != 'Login' && this.$route.name != 'AdminLogin' ">
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
      <div class="profile" v-if="$store.state.isAuth">
        <div class="avatar">
          <img :src="'http://localhost/ceres/backend/img/' + this.$store.state.user.avatar" alt="" />
        </div>
        <ul>
          <li><router-link to="/profile">Account</router-link></li>
          <li><a href="#" @click.prevent="logout">Logout</a></li>
        </ul>
      </div>
      <Button to="login" text="Get Started" v-else-if="!$store.state.isAuth" />
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
        this.$store.state.cart.length < 1
      ) {
        console.log(this.$store.state.cart.length);
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

    // log out
    logout() {
      this.$store.dispatch("logout");
      localStorage.removeItem("user_id");
      localStorage.removeItem("token");
      this.$router.push("/login");
    },
    // logout when token is expired
  },
  mounted() {
    if (localStorage.getItem("items") != null) {
      if (localStorage.getItem("items").length > 3) {
        this.hasItems = true;
      }
    }
  },
};
</script>

<style lang="scss">

$primary: #3ed749;

// Inputs
input:required:focus:valid:not([type="password"]) {
  outline: 2px solid $primary;
  background: url(~@/assets/img/icons/check.svg) no-repeat 97% 50%
    rgba($color: $primary, $alpha: 0.05);
  background-size: 25px;
}

input:required:focus:invalid:not([type="password"]) {
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

.profile {
  .avatar {
    width: 40px;
    height: 40px;
    border-radius: 50px;
    overflow: hidden;
  }

  img {
    width: 100% !important;
    height: 100%;
    object-fit: cover;
  }
  ul {
    position: absolute;
    border-radius: 5px;
    box-shadow: 0 0px 16px #0000000f;
    display: none !important;
    right: 0;
    li {
      padding: 10px 20px;
      &:hover {
        background: #f6f6f6;
      }
    }
  }
}
.profile:hover ul {
  display: flex !important;
  flex-direction: column;
  gap: 0px !important;
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
  position: relative;
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
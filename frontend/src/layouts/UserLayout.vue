<template>
  <div
    id="nav"
    class="container"
    v-if="this.$route.name != 'Login' && this.$route.name != 'AdminLogin'"
  >
    <div class="logo">
      <router-link to="/"
        ><img src="@/assets/img/logo.png" alt="Ceres"
      /></router-link>
    </div>
    <div v-if="mq.mdPlus == true">
      <ul>
        <li><router-link to="/">Home</router-link></li>
        <li><router-link to="/discover">Discover</router-link></li>
        <li><router-link to="/about">About Us</router-link></li>
        <li><router-link to="/contact">Contact Us</router-link></li>
      </ul>
    </div>
    <Slide
      :width="mq.xs ? '300' : '400'"
      noOverlay
      v-if="mq.smMinus == true"
      style="margin-left: auto"
    >
      <div>
        <ul style="flex-direction: column">
          <li><router-link to="/">Home</router-link></li>
          <li><router-link to="/discover">Discover</router-link></li>
          <li><router-link to="/about">About Us</router-link></li>
          <li><router-link to="/contact">Contact Us</router-link></li>
        </ul>
      </div>
      <div
        class="getstarted"
        style="align-items: flex-start; flex-direction: column"
      >
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
      </div>
    </Slide>
    <div class="getstarted">
      <router-link
        v-if="mq.mdPlus == true"
        class="cart"
        :class="{ hasItem: hasItems }"
        @click="checkCart"
        to="#"
        ><img
          class="shopping-cart"
          src="@/assets/img/icons/shopping-cart.svg"
          alt=""
      /></router-link>
      <div class="profile" v-if="$store.state.isAuth" @click="toggleProfile">
        <div class="avatar">
          <img
            :src="
              'http://localhost/ceres/backend/img/' +
              this.$store.state.user.avatar
            "
            alt=""
          />
        </div>

        <ul ref="drop">
          <li><router-link to="/profile">Account</router-link></li>
          <li><a href="#" @click.prevent="logout">Logout</a></li>
        </ul>
      </div>
      <Button to="/login" text="Get Started" v-else-if="!$store.state.isAuth" />
    </div>
  </div>
  <!-- <transition name="slide">
    <router-view />
  </transition> -->
  <router-view v-slot="{ Component }">
    <transition name="slide" mode="out-in">
      <component :is="Component" />
    </transition>
  </router-view>
  <footer
    v-if="this.$route.name != 'Login' && this.$route.name != 'AdminLogin'"
  >
    <p>Ceres - All Right Reserved 2022</p>
  </footer>
</template>

<script>
import Button from "@/components/Button.vue";
import { Slide } from "vue3-burger-menu";
import { createToast } from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";

export default {
  inject: ["mq"],
  components: {
    Button,
    Slide,
  },
  data() {
    return {
      hasItems: false,
      isProfile: false,
    };
  },
  methods: {
    toggleProfile() {
      this.$refs.drop.classList.toggle("profile-active");
      // this.isProfile = !this.isProfile;
      // if (this.isProfile) {
      //   this.$refs.drop.style.display = "flex";
      //   this.$refs.drop.style.flexDirection = "column";
      //   this.$refs.drop.style.gap = "0";
      // } else {
      //   this.$refs.drop.style.display = "none";
      // }
    },

    checkCart: function (e) {
      e.preventDefault();

      if (this.$store.state.cart.length < 1) {
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
  mounted() {},
};
</script>

<style lang="scss" >
.slide-enter-active,
.slide-leave-active {
  transition: all 0.5s ease;
}

.slide-enter-from,
.slide-leave-to {
  transform: translateX(10%);
  opacity: 0;
}

.slide-enter-to,
.slide-leave-from {
  transform: translateX(0);
  opacity: 1;
}
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

.f-col {
  flex-direction: column !important;
}
.text-center {
  text-align: center !important;
}
.mb {
  margin-bottom: 10px !important;
}
.gap {
  gap: 10px !important;
}
.mb-0 {
  margin-bottom: 0 !important;
}
.mt-0 {
  margin-top: 0 !important;
}
.d-none {
  display: none !important;
}

#app {
  font-family: "Poppins", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #4e4e4e;
}
.bm-burger-button {
  width: 32px;
  height: 26px;
}
.line-style {
  border-radius: 10px;
}
.bm-burger-button {
  position: relative;
  left: unset;
  top: unset;
}
#nav {
  .profile {
    cursor: pointer;
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
      display: none;
      right: 0;
      padding: 20px;
      background: #fff;
      margin-top: 20px;
      li {
        padding: 10px 20px;
        &:hover {
          background: #f6f6f6;
        }
      }

      &::before {
        content: "";
        display: block;
        position: absolute;
        top: -10px;
        right: 10px;
        width: 0;
        height: 0;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        border-bottom: 20px solid #fff;
      }
    }
    .profile-active {
      display: flex;
      flex-direction: column;
      gap: 0;
    }
  }
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
  padding: 30px;
}
#nav {
  padding: 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  gap: 10px;
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
footer {
  text-align: center;
  padding: 30px 0;
  background: $primary;
  color: white;
  margin-top: 100px;
}
</style>
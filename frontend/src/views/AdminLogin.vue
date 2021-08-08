<template>
  <div class="container">
    <div class="form-container">
      <h3 class="login">Sign In</h3>
      <form @submit.prevent="login">
        <div class="input-group">
          <input
            required
            type="email"
            id="email"
            name="email"
            v-model="email"
            placeholder="E-mail"
          />
        </div>
        <div class="input-group">
          <input
            required
            type="password"
            id="password"
            name="password"
            v-model="password"
            placeholder="Password"
          />
        </div>
        <Submit text="Login" />
      </form>
    </div>
  </div>
</template>

<script>
import ButtonFilled from "@/components/ButtonFilled.vue";
import Submit from "@/components/Submit.vue";

import { createToast } from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";

import axios from "axios";

export default {
  components: {
    ButtonFilled,
    Submit,
  },
  data() {
    return {
      password: "",
      email: "",
      token: {},
      user_id: "",
    };
  },
  methods: {
    async login(e) {
      e.preventDefault();

      const resp = await fetch(
        "http://localhost/ceres/backend/AdminController/login",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
        }
      );

      const jwt = await resp.json();
      console.log(jwt);
      if (jwt.Admin) {
        this.token = jwt.Token;
        this.admin_id = jwt.Admin.id;

        localStorage.setItem("admin_id", this.user_id);
        localStorage.setItem("admin_token", this.token);

        this.$store.dispatch("admin_login", jwt.Admin);

        createToast("Login successfully", {
          showIcon: true,
          swipeClose: true,
          position: "bottom-center",
          type: "success",
          transition: "slide",
          timeout: 4000,
        });

        // this.$router.push("/");
      } else {
        createToast("Incorrect email or password", {
          showIcon: true,
          swipeClose: true,
          position: "bottom-center",
          type: "danger",
          transition: "slide",
          timeout: 4000,
        });
      }
    },
  },
};
</script>

<style scoped lang="scss">
$primary: #3ed749;

a {
  text-decoration: none;
}

h3 {
  font-size: 30px;
}

.container {
  max-width: 100%;

  background: #3ed749;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.form-container {
  background: white;
  width: 500px;
  border-radius: 10px;
  padding: 40px;

  .toggle {
    display: flex;
    gap: 15px;
    margin: 20px 0;
  }

  .active {
    color: #111;
    border-bottom: 3px solid $primary;
    font-weight: 500;
  }
  a {
    color: rgba(17, 17, 17, 0.5);
    padding-bottom: 10px;
  }

  span {
    margin-top: 10px;
    display: block;
    text-align: center;
    font-size: 14px;
    a {
      color: $primary;
    }
  }
}
form {
  input {
    width: 100%;
    margin-bottom: 15px;
  }

  button[type="submit"] {
    width: 100%;
    font-weight: 400;
  }
}
</style>
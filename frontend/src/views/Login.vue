<template>
  <div class="container">
    <div class="form-container">
      <h3 class="login">Sign In</h3>
      <div class="toggle">
        <a
          href="#"
          @click.prevent="toggleForm('login')"
          :class="currentTab == 'login' ? 'active' : ''"
          >Sign in</a
        >
        <a
          href="#"
          @click.prevent="toggleForm('register')"
          :class="currentTab == 'register' ? 'active' : ''"
          >Registration</a
        >
      </div>
      <form @submit.prevent="login" v-if="currentTab == 'login'">
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
        <span
          >Don’t have an account ?
          <a @click.prevent="toggleForm('register')" href="#">Register</a></span
        >
      </form>
      <form v-if="currentTab == 'register'" @submit.prevent="checkEmail">
        <div class="input-group">
          <input
            type="text"
            id="name"
            name="name"
            v-model="name"
            placeholder="Your Name"
          />
        </div>
        <div class="input-group">
          <input
            type="email"
            id="email"
            name="email"
            v-model="email"
            placeholder="Email"
          />
        </div>
        <div class="input-group">
          <input
            type="password"
            id="password"
            name="password"
            v-model="password"
            placeholder="Password"
          />
        </div>
        <Submit text="Register" />
        <span
          >Already have an account ?
          <a @click.prevent="toggleForm('login')" href="#">Login</a></span
        >
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
      name: "",
      password: "",
      email: "",
      store: {},
      user_id: "",
      currentTab: "login",
    };
  },
  methods: {
    // toggle tabs

    toggleForm(formName) {
      this.currentTab = formName;
    },
    async login(e) {
      e.preventDefault();

      const resp = await fetch(
        "http://localhost/ceres/backend/UserController/find",
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

      if (jwt.User) {
        this.store = jwt.Token;
        this.user_id = jwt.User.id;

        localStorage.setItem("user_id", this.user_id);
        localStorage.setItem("token", this.store);

        this.$store.dispatch("login", true);

        createToast("Login successfully", {
          showIcon: true,
          swipeClose: true,
          position: "bottom-center",
          type: "success",
          transition: "slide",
          timeout: 4000,
        });

        this.$router.push("/");
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

    register() {
      console.log(this.checkEmail);
      if (!this.checkEmail()) {
        axios
          .post("http://localhost/ceres/backend/UserController/register/", {
            name: this.name,
            email: this.email,
            password: this.password,
          })
          .then(function (response) {
            console.log(response);
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },

    checkEmail() {
      axios
        .post("http://localhost/ceres/backend/UserController/checkEmail", {
          email: this.email,
        })
        .then((response) => {
          if (!response.data) {
            axios
              .post("http://localhost/ceres/backend/UserController/register/", {
                name: this.name,
                email: this.email,
                password: this.password,
              })
              .then(function (response) {
                console.log(response);
              })
              .catch(function (error) {
                console.log(error);
              });
          } else {
            alert("email already exist");
          }
        });
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
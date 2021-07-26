<template>
  <form>
    <div class="input-group">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" v-model="name" />
    </div>
    <div class="input-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" v-model="email" />
    </div>
    <div class="input-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" v-model="password" />
    </div>
    <ButtonFilled text="register" to="#" @click="register" />
  </form>
</template>

<script>
import ButtonFilled from "@/components/ButtonFilled.vue";

export default {
  components: {
    ButtonFilled,
  },
  data() {
    return {
      name: "",
      email: "",
      password: "",
    };
  },
  methods: {
    async register(e) {
      e.preventDefault();

      const resp = await fetch(
        "http://localhost/ceres/backend/UserController/register",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify({
            name: this.name,
            email: this.email,
            password: this.password,
          }),
        }
      );
    },
  },
};
</script>

<style>
</style>
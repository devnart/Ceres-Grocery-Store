<template>
  <div class="main">
    <div class="container">
      <header>
        <div class="col">
          <div class="avatar">
            <img
              :src="'http://localhost/ceres/backend/img/' + user.avatar"
              alt=""
            />
          </div>
          <div class="info">
            <h2 class="name">{{ user.name }}</h2>

            <p class="email">{{ user.email }}</p>
            <p class="phone">{{ user.phone }}</p>
            <p class="role">{{ user.role }}</p>
            <ButtonFilled to="#" text="Delete User" @click="deleteUser" />
          </div>
        </div>
      </header>

      <section class="orders">
        <h3>User Orders</h3>
        <div class="table">
          <div class="thead">
            <div class="tr">
              <div class="th">Id</div>
              <div class="th orders">Orders</div>
              <div class="th date">Date</div>
              <div class="th adress">Adress</div>
              <div class="th">Total</div>
              <div class="th">Status</div>
            </div>
          </div>

          <div class="tbody">
            <div class="tr" v-for="order in orders" :key="order.id">
              <div class="td">
                <div class="order-info">
                  <div class="order-number">
                    <span class="number">#{{ order.id }}</span>
                  </div>
                  <div class="order-title">
                    <span class="title">{{ order.products }}</span>
                  </div>
                  <div class="order-date">
                    <span class="date">{{ order.created }}</span>
                  </div>
                  <div class="order-adress">
                    <span class="adress">{{ order.adress }}</span>
                  </div>
                  <div class="order-price">
                    <span class="price">{{ order.totalPrice }}</span>
                  </div>
                  <div class="order-status">
                    <span
                      class="status"
                      :class="{
                        delivered: order.status == 'delivered',
                        pending: order.status == 'pending',
                        cancelled:
                          order.status == 'rejected' ||
                          order.status == 'cancelled',
                      }"
                      >{{ order.status }}</span
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import ButtonFilled from "@/components/ButtonFilled.vue";

import axios from "axios";

export default {
  components: {
    ButtonFilled,
  },
  data() {
    return {
      orders: [],
      user: [],
    };
  },
  methods: {
    // get user data
    getUser() {
      const id = this.$route.params.id;
      axios
        .post("http://localhost/ceres/backend/UserController/getUser", { id })
        .then((response) => {
          this.user = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getOrderByUid() {
      const userId = this.$route.params.id;
      // get product by uid
      // with axios post
      axios
        .post(
          "http://localhost/ceres/backend/OrderController/getOrdersByUserId",
          { userId }
        )
        .then((response) => {
          this.orders = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // delete user
    deleteUser() {
      axios
        .delete(
          `http://localhost/ceres/backend/UserController/delete/${this.$route.params.id}`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
            },
          }
        )
        .then((response) => {
          this.$router.push("/users");
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  mounted() {
    this.getUser();
    this.getOrderByUid();
  },
};
</script>

<style lang="scss" scoped>
header {
  justify-content: center;

  .info {
    text-align: center;
  }
}
.info {
  a {
    color: white;
    background-color: #fc573b;
    border: 2px solid #fc573b;

    &:hover {
      background-color: transparent;
      color: #fc573b;
    }
  }
}
</style>
<template>
  <main>
    <div class="container error" v-if="notFound">
      <p>Order not found!</p>
      <router-link to="/orders">Back to list</router-link>
    </div>
    <div class="container" v-if="!notFound">
      <div class="order-title">
        <h1>Order Deatils</h1>
        <div>
          <div class="order-total">
            <span
              >Order total:
              <span class="total">{{ order.totalPrice }}$</span></span
            >
            <img
              src="@/assets/img/icons/close.svg"
              alt="Reject"
              @click="rejectOrder(order.id)"
            />
            <img
              src="@/assets/img/icons/check.svg"
              alt="Accept"
              @click="acceptOrder(order.id)"
            />
            <img
              src="@/assets/img/icons/drag.svg"
              alt="Pending"
              @click="pendingOrder(order.id)"
            />
          </div>
        </div>
      </div>
      <div class="order-status">
        <!-- <span class="status delivered">Delivered</span> -->
        <span
          class="status"
          :class="{
            delivered: order.status == 'delivered',
            pending: order.status == 'pending',
            cancelled:
              order.status == 'cancelled' || order.status == 'rejected',
          }"
          >{{ order.status }}</span
        >
      </div>
      <div class="order-content">
        <div class="row">
          <div class="column">
            <h4>User Information</h4>
            <div class="user-info">
              <h5>{{ order.name }}</h5>
              <p>{{ order.email }}</p>
            </div>
          </div>
          <div class="column">
            <h4>Shipping Information</h4>
            <div class="shipping-info">
              <h5>{{ order.first_name + " " + order.last_name }}</h5>
              <p>{{ order.adress }}</p>
              <p>{{ order.city }}</p>
              <p>{{ order.phone }}</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="column">
            <h4>Payment</h4>
            <div class="payment-info">
              <p>Cash on delivery</p>
            </div>
          </div>
          <div class="column">
            <h4>Products</h4>
            <div class="products-info">
              <p>{{ order.products }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      order: [],
      notFound: false,
    };
  },
  methods: {
    // get single order axios
    getOrder() {
      axios
        .get(
          `http://localhost/ceres/backend/orderController/getOrderById/${this.$route.params.id}`
        )
        .then((response) => {
          if (response.data == false) {
            this.notFound = true;
          } else {
            this.order = response.data;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // reject order
    rejectOrder(orderId) {
      axios
        .post("http://localhost/ceres/backend/OrderController/rejectOrder", {
          orderId,
        })
        .then((response) => {
          this.getOrder();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // accept order
    acceptOrder(orderId) {
      axios
        .post("http://localhost/ceres/backend/OrderController/acceptOrder", {
          orderId,
        })
        .then((response) => {
          this.getOrder();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // pending order
    pendingOrder(orderId) {
      axios
        .post("http://localhost/ceres/backend/OrderController/pendingOrder", {
          orderId,
        })
        .then((response) => {
          this.getOrder();
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.getOrder();
  },
};
</script>

<style lang="scss" scoped>
$primary: #3ed749;

.container {
  padding-top: 50px;
}
p {
  font-size: 14px;
  opacity: 0.7;
}
.order-title {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.order-total {
  align-items: center;
  display: flex;
  gap: 5px;
  img {
    cursor: pointer;
    width: 40px;
    height: 40px;
  }
  span {
    font-size: 14px;
    color: #a5a5a5;
  }
  span.total {
    color: $primary;
    font-size: 1.5rem;
    font-weight: 700;
    margin-right: 10px;
  }
}
.status {
  justify-content: unset;
}
.order-content {
  margin-top: 40px;
  background: #f9f9f9;
  padding: 30px;
  border-radius: 10px;

  .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;

    &:first-of-type {
      margin-bottom: 20px;
    }
    .column {
      flex: 1;

      h4 {
        border-bottom: 1px dashed #cecece;
        margin-bottom: 10px;
        padding-bottom: 5px;
      }
    }
  }
}
</style>
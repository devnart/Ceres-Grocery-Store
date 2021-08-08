<template>
  <main>
    <div class="container">
      <section class="orders">
        <h3>Orders</h3>
        <p>All orders by date</p>
        <div class="table">
          <div class="tbody">
            <div class="thead">
              <div class="tr">
                <div class="th">Id</div>
                <div class="th">Name</div>
                <div class="th order">Order</div>
                <div class="th adress">Adress</div>
                <div class="th">Options</div>
              </div>
            </div>
            <div class="tr" v-for="order in orders" :key="order.id">
              <div class="td">
                <div class="order-info">
                  <div class="order-id">
                    <span class="id">#{{ order.id }}</span>
                  </div>
                  <div class="user-name">
                    <span class="name">{{
                      order.first_name + " " + order.last_name
                    }}</span>
                  </div>
                  <div class="order-orders">
                    <span class="orders">{{ order.products }}</span>
                  </div>
                  <div class="order-adress">
                    <span class="order">{{ order.adress }}</span>
                  </div>
                  <div class="order-status" v-if="order.status == 'pending'">
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
                    <!-- <img
                      src="@/assets/img/icons/more-horizontal.svg"
                      alt="User Info"
                      @click="
                        $router.push({
                          name: 'Order',
                          params: { id: order.id },
                        })
                      "
                    /> -->
                  </div>
                  <div class="order-status" v-else>
                    <span
                      class="status"
                      :class="{
                        delivered: order.status == 'delivered',
                        cancelled:
                          order.status == 'cancelled' ||
                          order.status == 'rejected',
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
      <pagination
        :currentPage="currentPage"
        :pageCount="totalPages"
        page="orders"
      />
    </div>
  </main>
</template>

<script>
import Pagination from "@/components/Pagination.vue";

import axios from "axios";

export default {
  components: {
    Pagination,
  },
  data() {
    return {
      orders: [],
      currentPage: this.$route.params.number ?? 1,
      totalPages: Number,
    };
  },
  methods: {
    getOrders() {
      return axios
        .post("http://localhost/ceres/backend/orderController/getAllOrders", {
          page: this.currentPage,
        })
        .then((response) => {
          this.orders = response.data.orders;
          this.totalPages = response.data.pages;

          console.log(response.data);
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
          this.getOrders();
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
          this.getOrders();
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getOrders();
    // console.log(this.$route.params.page);
  },
};
</script>

<style lang="scss" scoped>
a {
  text-decoration: none;
}
.thead {
  .tr {
    padding: 10px 0;
    .th {
      color: #000;
      font-size: 14px;
    }
    .th:first-child {
      flex: 0.5;
    }
  }
}
.orders {
  padding-top: 20px;
  .table {
    margin-top: 15px;
  }
  p {
    font-size: 12px;
  }
}

.orders h3 {
  margin-bottom: 0;
}

.tbody {
  background: #fcfcfc;
  padding: 15px;
  border-radius: 5px;
}
.order-info {
  padding: 15px 0;
  span {
    color: #6c6c6c;
    font-size: 14px;
  }
}
.order-id {
  flex: 0.5;
}
.order-orders,
.th.order {
  flex: 3;
}
.order-adress,
.th.adress {
  flex: 2;
}

.order-status {
    justify-content: center;
  align-items: center;
  display: flex;
  gap: 5px;
  img {
    cursor: pointer;
    width: 32px;
    height: 32px;
  }
}
</style>
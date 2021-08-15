<template>
  <main>
    <div class="container">
      <div class="row">
        <h4>Revenue</h4>
        <p>This month summary</p>
        <div class="revenue">
          <div class="revenue-details">
            <div class="revenue-detail">
              <div class="revenue-detail-title">
                <h3>Today</h3>
              </div>
              <div class="revenue-detail-value">
                <span
                  >$<span>{{ revenue.today ?? 0 }}</span></span
                >
              </div>
              <div class="states">
                <img src="@/assets/img/icons/trending-down.svg" alt="" />
                <span><span>-28</span>% from yesterday</span>
              </div>
            </div>
            <div class="revenue-detail">
              <div class="revenue-detail-title">
                <h3>Yesterday</h3>
              </div>
              <div class="revenue-detail-value">
                <span
                  >$<span>{{ revenue.yesterday ?? 0 }}</span></span
                >
              </div>
              <div class="states">
                <img src="@/assets/img/icons/trending-up.svg" alt="" />
                <span><span>+12</span>% from yesterday</span>
              </div>
            </div>
            <div class="revenue-detail">
              <div class="revenue-detail-title">
                <h3>Last Week</h3>
              </div>
              <div class="revenue-detail-value">
                <span
                  >$<span>{{ revenue.thisWeek ?? 0 }}</span></span
                >
              </div>
              <div class="states">
                <img src="@/assets/img/icons/trending-down.svg" alt="" />
                <span><span>-42</span>% from last week</span>
              </div>
            </div>
          </div>
          <div class="revenue-total revenue-details">
            <div class="revenue-detail">
              <div class="revenue-detail-title">
                <h3>This Month</h3>
                <p>This month total revenue</p>
              </div>
              <div class="revenue-detail-value">
                <span
                  >$<span>{{ revenue.thisMonth ?? 0 }}</span></span
                >
              </div>
              <div class="states">
                <img src="@/assets/img/icons/trending-down.svg" alt="" />
                <span><span>-28</span>% from yesterday</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row tables">
        <div class="column">
          <div class="section-header">
            <div>
              <h4>Last Orders</h4>
              <p>Items ordered recenlty</p>
            </div>
            <div class="see-more" @click="$router.push({ name: 'Orders' })">
              <img src="@/assets/img/icons/arrow-right.svg" alt="" />
            </div>
          </div>

          <div class="last-orders">
            <div class="table">
              <div class="tbody">
                <!-- <div class="tr" v-for="order in orders" :key="order.id"> -->
                <div class="tr" v-for="order in orders" :key="order.id">
                  <div class="td">
                    <div class="order-info">
                      <div class="order-number">
                        <span class="number">#{{ order.id }}</span>
                        <!-- <span class="number">#241</span> -->
                      </div>
                      <div class="order-avatar">
                        <span class="avatar"
                          ><img
                            :src="
                              'http://localhost/ceres/backend/img/' +
                              order.avatar
                            "
                            :alt="order.name"
                        /></span>
                      </div>
                      <div class="order-name">
                        <!-- <span class="name">John Alber Doe</span> -->
                        <span class="number">{{ order.name }}</span>
                      </div>

                      <div class="order-title">
                        <!-- <span class="title">Tomato(4) Potato(2)</span> -->
                        <span class="title">{{ order.products }}</span>
                      </div>
                      <div class="order-price">
                        <!-- <span class="price">212.09$</span> -->
                        <span class="price">${{ order.totalPrice }}</span>
                      </div>
                      <div class="order-status">
                        <!-- <span class="status delivered">Delivered</span> -->
                        <span
                          class="status"
                          :class="{
                            delivered: order.status == 'delivered',
                            pending: order.status == 'pending',
                            cancelled:
                              order.status == 'cancelled' ||
                              order.status == 'rejected',
                          }"
                          >{{ order.status }}</span
                        >
                      </div>
                      <div class="order-options">
                        <img
                          src="@/assets/img/icons/settings.svg"
                          alt=""
                          @click="
                            $router.push({
                              name: 'Order',
                              params: { id: order.id },
                            })
                          "
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="section-header">
            <div>
              <h4>Latest Clients</h4>
              <p>Client registred recenlty</p>
            </div>
            <div class="see-more" @click="$router.push({ name: 'Users' })">
              <img src="@/assets/img/icons/arrow-right.svg" alt="" />
            </div>
          </div>
          <div class="last-clients">
            <div class="table">
              <div class="tbody">
                <div class="tr" v-for="client in clients" :key="client.id">
                  <div class="td">
                    <div class="order-info">
                      <div style="display: flex; gap: 10px">
                        <div class="client-avatar">
                          <span class="avatar"
                            ><img
                              :src="
                                'http://localhost/ceres/backend/img/' +
                                client.avatar
                              "
                              alt=""
                          /></span>
                        </div>
                        <div class="client-name">
                          <span class="name">{{ client.name }}</span>
                          <p class="role">{{ client.role }}</p>
                        </div>
                      </div>
                      <div class="order-options">
                        <img
                          @click="
                            $router.push({
                              name: 'User',
                              params: { id: client.id },
                            })
                          "
                          src="@/assets/img/icons/more-horizontal.svg"
                          alt=""
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
      orders: [],
      clients: [],
      revenue: [],
      todayRevenue: Number,
      yesterdayRevenue: Number,
    };
  },
  methods: {
    // get revenue
    getRevenue() {
      axios
        .get("http://localhost/ceres/backend/productController/revenues/")
        .then((response) => {
          this.revenue = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // get orders axios
    getOrders() {
      return axios
        .get("http://localhost/ceres/backend/orderController/getLastOrders")
        .then((response) => {
          this.orders = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    // get clients axios
    getClients() {
      return axios
        .get("http://localhost/ceres/backend/userController/getLast4Clients")
        .then((response) => {
          this.clients = response.data;
        });
    },
  },
  mounted() {
    this.getOrders();
    this.getClients();
    this.getRevenue();
  },
};
</script>

<style scoped lang="scss">
$primary: #3ed749;

.section-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
  .see-more {
    cursor: pointer;
    background: $primary;
    padding: 12px;
    width: 50px;
    height: 50px;
    border-radius: 5px;
  }
}
.order-options {
  img {
    cursor: pointer;
  }
}
.order-info {
  .order-avatar,
  .order-options,
  .client-avatar {
    flex: unset;
  }
  .order-status {
    flex: 2;
  }
  .order-options {
    display: flex;
    padding: 5px;
    background: #f6f6f6;
    border-radius: 5px;

    //   align-items: center;
  }
  .order-title {
    flex: 4;
  }
}

.row.tables {
  padding-top: 20px;
  display: flex;
  justify-content: space-between;
  gap: 30px;
  .column:first-child {
    flex: 2;
  }
  .column:last-child {
    flex: 1;
  }
}
h4 {
  font-size: 18px;
}
h4 + p {
  font-size: 12px;
}
.revenue {
  margin: 30px 0;
  display: flex;
  gap: 30px;
}
.revenue-details {
  background: #fcfcfc;
  display: flex;
  padding: 30px 60px;
  border-radius: 5px;
  gap: 60px;
  flex: 3;

  .revenue-detail {
    display: flex;
    flex-direction: column;

    .revenue-detail-title {
      font-size: 18px;
      color: #d1d1d1;
    }
    .revenue-detail-value {
      font-size: 44px;
      color: $primary;
      font-weight: 900;
    }
    .states {
      display: flex;
      img {
        width: 18px;
        margin-right: 5px;
      }
      span {
        color: #6c6c6c;
        font-size: 12px;
      }
    }
  }
}
.revenue-total {
  flex: 1;
  background: $primary;
  .revenue-detail-title,
  .revenue-detail-value,
  .states span {
    color: #fff !important;
  }
  .revenue-detail-title {
    p {
      font-size: 12px;
      font-weight: 300;
    }
  }
}

// last order table
.tbody {
  background: #fcfcfc;
  padding: 15px;
  border-radius: 5px;
}
.order-info {
  padding: 10px;
  font-size: 13px;
  .order-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50px;
    overflow: hidden;

    img {
      height: 100%;
      object-fit: cover;
    }
  }
}
.last-clients {
  .client-avatar {
    width: 40px;
    height: 40px;
    border-radius: 5px;
    overflow: hidden;
  }
  .client-name {
    text-align: left;
  }
}

.role {
  font-size: 14px;
  font-weight: 400;
  font-style: italic;
  line-height: 1;
  opacity: 0.3;
}
</style>
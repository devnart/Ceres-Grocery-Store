<template>
  <main>
    <div class="container">
      <section class="orders">
        <h3>Clients</h3>
        <p>Registred Clients</p>
        <div class="table">
          <div class="tbody">
            <div class="thead">
              <div class="tr">
                <div class="th">Id</div>
                <div class="th">Name</div>
                <div class="th">Email</div>
                <div class="th">Phone</div>
                <div class="th">Role</div>
                <div class="th">Options</div>
              </div>
            </div>
            <div class="tr" v-for="user in clients" :key="user.id">
              <div class="td">
                <div class="order-info">
                  <div class="user-id">
                    <span class="id">#{{ user.id }}</span>
                  </div>
                  <div class="user-name user-avatar">
                    <img
                      class="avatar"
                      :src="'http://localhost/ceres/backend/img/' + user.avatar"
                      alt=""
                    />
                    <span class="name">{{ user.name }}</span>
                  </div>
                  <div class="user-email">
                    <span class="email">{{ user.email }}</span>
                  </div>
                  <div class="user-phone">
                    <span class="phone">0706081245</span>
                  </div>
                  <div class="user-role">
                    <span class="role">{{ user.role }}</span>
                  </div>
                  <div class="user-option">
                    <img
                      src="@/assets/img/icons/more-horizontal.svg"
                      alt="User Info"
                      @click="
                        $router.push({ name: 'User', params: { id: user.id } })
                      "
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <pagination :currentPage="currentPage" :pageCount="totalPages" page="users" />
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
      clients: [],
      currentPage: this.$route.params.number ?? 1,
      totalPages: Number,
    };
  },
  methods: {
    // get clients axios
    getClients() {
      return axios
        .post("http://localhost/ceres/backend/userController/getAll", {
          page: this.currentPage,
        })
        .then((response) => {
          this.clients = response.data.users;
          this.totalPages = response.data.pages;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getClients();
    // console.log(this.$route.params.page);
  },
};
</script>

<style lang="scss" scoped>
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
.user-id {
  flex: 0.5;
}
.user-avatar {
  display: flex;
  align-items: center;
  gap: 10px;

  .avatar {
    width: 35px;
    height: 35px;
    border-radius: 5px;
  }
}
.user-option {
  display: flex;
  justify-content: center;

  img {
    cursor: pointer;
    padding: 5px;
    background: #f6f6f6;
    border-radius: 5px;
    width: 32px;
    height: 32px;

    &:hover {
      background: #3ed749;
  }
}}
</style>
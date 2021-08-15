<template>
  <main>
    <div class="container">
      <section class="orders">
        <h3>Products</h3>
        <p>All products ordred by last added</p>
        <div class="table">
          <div class="tbody">
            <div class="thead">
              <div class="tr">
                <div class="th">Id</div>
                <div class="th">Name</div>
                <div class="th" style="flex: 3">Description</div>
                <div class="th">Category</div>
                <div class="th">Unit</div>
                <div class="th">Price</div>
                <div class="th">Options</div>
              </div>
            </div>
            <div class="tr" v-for="product in products" :key="product.id">
              <div class="td">
                <div class="order-info">
                  <div class="product-id">
                    <span class="id">#{{ product.id }}</span>
                  </div>
                  <div class="user-name user-avatar">
                    <img
                      class="avatar"
                      :src="
                        'http://localhost/ceres/backend/img/products/' +
                        product.img
                      "
                      alt=""
                    />
                    <span class="name">{{ product.name }}</span>
                  </div>
                  <div class="product-description">
                    <span class="description">{{ product.description }}</span>
                  </div>
                  <div class="product-category">
                    <span class="category">{{ product.category }}</span>
                  </div>
                  <div class="product-unit">
                    <span class="unit">{{ product.unit }}</span>
                  </div>
                  <div class="product-price">
                    <span class="price">{{ product.price }}$</span>
                  </div>
                  <div class="user-option">
                    <img
                      src="@/assets/img/icons/more-horizontal.svg"
                      alt="Edit Product"
                      @click="
                        $router.push({
                          name: 'Edit Products',
                          params: { id: product.id },
                        })
                      "
                    />
                    <img
                      src="@/assets/img/icons/close.svg"
                      alt="User Info"
                      @click="deleteProduct(product.id)"
                    />
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
        page="products"
      />
      <!-- <Modal v-if="showModal" :data="product" @close="showModal = false"  /> -->
    </div>
  </main>
</template>

<script>
import { createToast } from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";

import Pagination from "@/components/Pagination.vue";
// import Modal from "@/components/Modal.vue";

import axios from "axios";
export default {
  components: {
    Pagination,
    // Modal
  },
  data() {
    return {
      currentPage: this.$route.params.number ?? 1,
      totalPages: Number,
      products: [],
      product: {},
      // showModal: false,
    };
  },
  methods: {
    editProduct(product) {
      // this.showModal = true;
      this.product = product;
    },

    getProducts() {
      return axios
        .post("http://localhost/ceres/backend/productController/getProducts", {
          page: this.currentPage,
        })
        .then((response) => {
          this.products = response.data.products;
          this.totalPages = response.data.pages;

          console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // delete product
    deleteProduct(id) {
      axios
        .delete(
          "http://localhost/ceres/backend/productController/deleteProduct/",
          {
            data: {
              id: id,
            },
            headers: {
              Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
            },
          }
        )
        .then((response) => {
          this.getProducts();

          createToast("Item deleted successfully", {
            showIcon: true,
            swipeClose: true,
            position: "bottom-center",
            type: "success",
            transition: "slide",
            timeout: 3000,
          });
        });
    },
  },
  mounted() {
    this.getProducts();
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
    object-fit: cover;
  }
}

.product-description {
  flex: 3;
}
.user-option {
  display: flex;
  gap: 5px;
  justify-content: center;

  img {
    cursor: pointer;
    padding: 5px;
    background: #f6f6f6;
    border-radius: 5px;
    width: 32px;
    height: 32px;

    &:last-child {
      padding: 0;
    }
  }
}
</style>
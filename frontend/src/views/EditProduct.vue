<template>
  <main>
    <div class="row">
      <div class="column">
        <div class="container">
          <form @submit.prevent="editProduct()" ref="form">
            <div class="form-group">
              <input
                type="text"
                id="name"
                placeholder="Name"
                :value="product.name"
                name="name"
              />
            </div>
            <div class="form-group">
              <input
                type="text"
                id="description"
                placeholder="Description"
                :value="product.description"
                name="description"
              />
            </div>
            <div class="form-group">
              <div class="boxes">
                <label for="vegetables" @click="checkCategory('vegetables')">
                  <div class="box" ref="vegetables">
                    <img src="@/assets/img/vegetables_c.png" alt="Vegetables" />
                  </div>
                </label>
                <input
                  type="radio"
                  id="vegetables"
                  name="category"
                  value="vegetables"
                  :checked="product.category == 'vegetables' ? true : false"
                />
                <label for="fruits" @click="checkCategory('fruits')">
                  <div class="box" ref="fruit">
                    <img src="@/assets/img/fruits_c.png" alt="Fruits" />
                  </div>
                </label>
                <input
                  type="radio"
                  id="fruits"
                  name="category"
                  value="fruits"
                  :checked="product.category == 'fruits' ? true : false"
                />
              </div>
            </div>
            <div class="form-group">
              <select name="unit" id="unit">
                <option
                  :selected="product.unit == 'kg' ? true : false"
                  value="kg"
                >
                  kg
                </option>
                <option
                  :selected="product.unit == 'lot' ? true : false"
                  value="lot"
                >
                  Lot
                </option>
              </select>
            </div>
            <div class="form-group">
              <input
                type="text"
                id="price"
                placeholder="Price"
                name="price"
                :value="product.price"
              />
            </div>
            <input type="submit" name="submit" value="Update Product" />
          </form>
        </div>
      </div>
      <div class="column">
        <h2>You are about to update {{ product.name }}</h2>
      </div>
    </div>
  </main>
</template>

<script>
import { createToast } from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";

import axios from "axios";

export default {
  data() {
    return {
      product: {},
    };
  },
  methods: {
    // get single product
    getProduct() {
      const id = this.$route.params.id;
      axios
        .get(`http://localhost/ceres/backend/productController/getSingle/${id}`)
        .then((response) => {
          this.product = response.data;
          this.checkCategory(this.product.category);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // edit product
    editProduct() {
      const id = this.$route.params.id;
      var formData = new FormData(this.$refs.form);

      const config = {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
        },
      };
      axios
        .post(
          `http://localhost/ceres/backend/productController/updateProduct/${id}`,
          formData,
          config
        )
        .then((response) => {
          this.getProduct();
          if (response.data == true) {
            createToast("Product updated successfully", {
              showIcon: true,
              swipeClose: true,
              position: "bottom-center",
              type: "success",
              transition: "slide",
              timeout: 4000,
            });
          } else {
            createToast("Update error", {
              showIcon: true,
              swipeClose: true,
              position: "bottom-center",
              type: "danger",
              transition: "slide",
              timeout: 4000,
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    checkCategory(category) {
      console.log(category);
      if (category === "vegetables") {
        this.$refs.fruit.style.backgroundColor = "transparent";

        this.$refs.vegetables.style.backgroundColor = "#3ed749";
      } else if (category === "fruits") {
        this.$refs.vegetables.style.backgroundColor = "transparent";

        this.$refs.fruit.style.backgroundColor = "#3ed749";
      }
    },
  },
  mounted() {
    this.getProduct();
  },
};
</script>

<style lang="scss" scoped>
$primary: #3ed749;
form {
  width: 550px;
  display: flex;
  flex-direction: column;
}
.row {
  display: flex;
  .column:first-child {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 2;
  }
  .column:nth-child(2) {
    height: 100vh;
    flex: 1;
    background-image: linear-gradient(#3ed74898, #3ed74898),
      url("~@/assets/img/fruits-vegetables.jpg");

    h2 {
      font-size: 52px;
      font-style: normal;
      font-weight: 800;
      line-height: 1;
      letter-spacing: 0em;
      text-align: left;
      color: white;
      margin: 60px;
    }
  }
}
.form-group {
  margin-bottom: 10px;
}
.boxes {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 40px;
  margin: 40px 0;
  input {
    display: none;
  }
}
.box {
  width: 170px;
  height: 170px;
  box-shadow: 0px 4px 4px rgba(51, 51, 51, 0.04),
    0px 4px 4px rgba(51, 51, 51, 0.04);
  border-radius: 30px;
  display: flex;
  justify-content: center;
  img {
    width: 230px;
    object-fit: contain;
  }
}

input[type="submit"] {
  cursor: pointer;
  background: $primary;
  color: white;
  font-size: 16px;
  border: none;
  padding: 15px 20px;
  border-radius: 5px;
  border: 2px solid $primary;
  transition: 200ms;
  align-self: flex-end;
  &:hover {
    background: transparent;
    color: $primary;
  }
}

select,
input:not([type="submit"]) {
  box-shadow: 0px 4px 4px rgba(51, 51, 51, 0.04),
    0px 4px 16px rgba(51, 51, 51, 0.04) !important;
  width: 100%;
}
</style>
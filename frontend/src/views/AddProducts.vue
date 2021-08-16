<template>
  <main>
    <div class="row">
      <div class="column">
        <div class="container">
          <form
            @submit.prevent="addProduct()"
            ref="form"
            enctype="multipart/form-data"
          >
            <div class="form-group">
              <input
                type="text"
                id="name"
                placeholder="Name"
                v-model="name"
                name="name"
              />
            </div>
            <div class="form-group">
              <input
                type="text"
                id="description"
                placeholder="Description"
                name="description"
                v-model="description"
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
                  v-model="category"
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
                  v-model="category"
                />
              </div>
            </div>
            <div class="form-group">
              <select name="unit" id="unit">
                <option selected value="kg">kg</option>
                <option value="lot">Lot</option>
              </select>
            </div>
            <div class="form-group">
              <input
                type="text"
                id="price"
                placeholder="Price"
                name="price"
                v-model="price"
              />
            </div>
            <div class="form-group">
              <label for="image">
                <div>
                  <p><span>Select a file</span> or drag in form</p>
                  <p>PNG, jpg, files up to 8 MB in size</p>
                </div>
                <img
                  class="upload-icon"
                  src="@/assets/img/icons/upload.svg"
                  alt=""
                />
              </label>
              <input
                accept="image/png, image/jpeg"
                type="file"
                name="img"
                id="image"
                @change="getImage"
              />
            </div>
            <input type="submit" name="submit" value="+ Add Product" />
          </form>
        </div>
      </div>
      <div class="column">
        <h2>Feed it, don't eat it. Live green and go green.</h2>
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
      name: "",
      description: "",
      category: "vegetables",
      price: "",
      unit: "",
      img: "",
    };
  },
  //   computed: {
  //     categoryName() {
  //       return this.category === "vegetables" ? "Vegetables" : "Fruits";
  //     },
  //   },
  methods: {
    checkCategory(category) {
      if (category === "vegetables") {
        this.$refs.fruit.style.backgroundColor = "transparent";

        this.$refs.vegetables.style.backgroundColor = "#3ed749";
      } else if (category === "fruits") {
        this.$refs.vegetables.style.backgroundColor = "transparent";

        this.$refs.fruit.style.backgroundColor = "#3ed749";
      }
    },
    setCategory() {
      this.category = "vegetables";
    },

    // get image
    getImage(file) {
      // max input size
      if (eval(file.target.files[0].size / 1e6) > 8) {
        alert("Image size is too large must be below 8MB");
      } else {
        this.img = file.target.files[0];
      }
    },

    addProduct() {
      var formData = new FormData(this.$refs.form);
      const config = {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
          "Content-Type": "multipart/form-data",
        },
      };
      // add product axios
      axios
        .post(
          "http://localhost/ceres/backend/productController/addProduct/",
          formData,
          config
        )
        .then((response) => {
          if (response.data == true) {
            createToast("Product added successfully", {
              showIcon: true,
              swipeClose: true,
              position: "bottom-center",
              type: "success",
              transition: "slide",
              timeout: 4000,
            });
            this.name = "";
            this.description = "";
            this.category = "";
            this.price = "";
            this.unit = "";
            this.image = "";
          } else {
            createToast("Product not added", {
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
  },
  mounted() {
    this.setCategory();
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
label[for="image"],
select,
input:not([type="submit"]) {
  box-shadow: 0px 4px 4px rgba(51, 51, 51, 0.04),
    0px 4px 16px rgba(51, 51, 51, 0.04) !important;
  width: 100%;
}

#image {
  display: none;
}
label[for="image"] {
  cursor: pointer;
  justify-content: space-between;
  align-items: center;
  display: flex;
  border-radius: 4px;
  padding: 15px 10px;
  overflow: hidden;

  span {
    color: $primary;
  }
  p:first-child {
    color: #000;
    margin-bottom: 5px;
  }
  p:last-child {
    color: #cdcdcd;
    font-size: 14px;
  }
  .upload-icon {
    transition: cubic-bezier(0, 0.82, 0.13, 0.78) 200ms;

    transform: translateY(80px);
    width: 40px;
  }

  &:hover .upload-icon {
    transform: translateY(0);
  }
}
</style>
<template>
  <div class="cart container">
    <form @submit.prevent="checkout">
      <div class="row" :class="mq.smMinus ? 'f-col' : ''">
        <main>
          <div class="input">
            <input
              type="text"
              required
              id="fname"
              name="fname"
              v-model="firstName"
              placeholder="First name"
            />
          </div>
          <div class="input">
            <input
              type="text"
              required
              id="lname"
              name="lname"
              v-model="lastName"
              placeholder="Last name"
            />
          </div>
          <div class="input">
            <input
              type="number"
              required
              id="phone"
              name="phone"
              v-model="phone"
              placeholder="Phone number"
            />
          </div>
          <div class="input">
            <input
              type="text"
              required
              id="city"
              name="city"
              v-model="city"
              placeholder="City"
            />
          </div>
          <div class="input">
            <input
              type="text"
              required
              id="adress"
              name="adress"
              v-model="adress"
              placeholder="Street Adress"
            />
          </div>
        </main>
        <aside>
          <!-- <div class="products" :class="mq.xs ? 'text-center' : ''"> -->
          <transition-group
            name="list"
            tag="div"
            class="products"
            :class="mq.xs ? 'text-center' : ''"
          >
            <div class="product" v-for="product in products" :key="product.id">
              <div class="img-container">
                <img
                  :src="
                    'http://localhost/ceres/backend/img/products/' + product.img
                  "
                  alt=""
                />
              </div>
              <div class="info">
                <h2 class="product-title">{{ product.name }}</h2>
                <h2 class="product-price">
                  {{
                    (
                      Math.round(product.price * product.qty * 100) / 100
                    ).toFixed(2)
                  }}$
                </h2>
                <p>
                  Quantity :
                  <strong>{{ product.qty }}{{ product.unit }}</strong>
                </p>
              </div>
              <Popper arrow hover content="Delete from cart?">
                <i
                  @click="$store.commit('REMOVE_CART', product)"
                  class="fas fa-times"
                ></i>
              </Popper>
            </div>
            <div class="total">
              <span>Cart total :</span>

              <input id="total" readonly name="total" v-model="countTotal" />
            </div>

            <Submit text="checkout" style="width: 100%" />
          </transition-group>
          <!-- </div> -->
        </aside>
      </div>
    </form>
  </div>
</template>

<script>
import Product from "@/components/Product.vue";
import Submit from "@/components/Submit.vue";

import Popper from "vue3-popper";

import axios from "axios";

export default {
  inject: ["mq"],

  name: "Home",
  components: {
    Submit,
    Product,

    Popper,
  },
  data() {
    return {
      products: this.$store.state.cart,
      total: 0,
      finalProducts: [],
      firstName: this.$store.state.user.name,
      lastName: "",
      city: "",
      adress: "",
      phone: this.$store.state.user.phone,
    };
  },
  methods: {
    finalCart: function () {
      this.products.forEach((element) => {
        this.finalProducts += `${element.name}(${element.qty}) `;
      });
      console.log(this.finalProducts);
    },

    // Posting order details to database

    checkout: function (e) {
      e.preventDefault();
      let self = this;

      const config = {
        headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
      };
      if (this.$store.state.isAuth) {
        axios
          .post(
            "http://localhost/ceres/backend/productController/checkout/",
            {
              clientId: localStorage.getItem("user_id"),
              products: this.finalProducts,
              first_name: this.firstName,
              last_name: this.lastName,
              phone: this.phone,
              city: this.city,
              adress: this.adress,
              totalPrice: this.total,
            },
            config
          )
          .then(function (response) {
            localStorage.removeItem("items");
            // empty cart from store
            self.$store.commit("CLEAR_CART");
            // redirect to success page
            self.$router.push("/thanks");
          })
          .catch(function (error) {
            console.log(error);
          });
      } else {
        self.$router.push("/login");
      }
    },
  },
  computed: {
    countTotal: function () {
      this.total = 0;
      this.products.forEach((element) => {
        this.total += element.price * element.qty;
      });
      return "$" + this.total;
    },
  },
  created() {
    this.$store.dispatch("checkJWT");
    this.finalCart();
  },
};
</script>

<style lang="scss">
.list-item {
  display: inline-block;
  margin-right: 10px;
}
.list-enter-active,
.list-leave-active {
  transition: all 1s ease;
}
.list-leave-active {
  position: absolute;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: scale(0.6);
}

.list-move {
  transition: all 1s ease;
}

$primary: #3ed749;

:deep(.popper) {
  background: #333333;
  color: #ffffff;
  border-radius: 6px;
  padding: 10px;
  font-size: 12px;
}
:deep(.popper #arrow::before) {
  background: #534d4d;
}
textarea,
select,
input:not(input[readonly]):not([type="submit"]):not(.quantity input) {
  /* Colors / White */
  background: #ffffff;
  /* Shadow */
  box-shadow: 0px 4px 4px rgba(51, 51, 51, 0.04),
    0px 4px 4px rgba(51, 51, 51, 0.04);
  border-radius: 4px;
  border: none;
  padding: 15px 10px;
  font-size: 16px;
  color: rgba(17, 17, 17, 0.48);
}
i {
  cursor: pointer;
}
</style>


<style scoped lang="scss">
$primary: #3ed749;

.cart {
  margin-top: 80px;
}
.total {
  margin: 20px 0;
  display: flex;
  justify-content: space-between;
  span {
    color: #6d6d6d;
  }
}
.row {
  display: flex;
  gap: 20px;
  main {
    flex: 2;
  }
  aside {
    flex: 1;
    background-color: #fbfbfb;
    border-radius: 10px;
    .products {
      padding: 30px;
    }
    .product {
      gap: 20px;
      display: flex;
      padding: 30px;
      background-color: #fff;
      align-items: center;
      justify-content: space-between;

      .info {
        flex-direction: column;

        .quantity {
          display: flex;
        }
      }
    }
    .img-container {
      height: 100px;
      width: 100px;
      img {
        height: 100%;
        object-fit: cover;
      }
    }
  }

  #total {
    background: transparent;
    border: none;
    text-align: center;
    color: $primary;
    font-size: 20px;
    outline: none;
    font-weight: 700;
    font-family: "Recoleta", serif;
    text-align: right;
    width: 100px;
  }
}
form {
  .input {
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;
  }
}

.input-number {
  width: 50px;
  padding: 0 12px;
  vertical-align: top;
  text-align: center;
  outline: none;
}

.input-number,
.input-number-decrement,
.input-number-increment {
  border: 1px solid #ccc;
  height: 40px;
  user-select: none;
}

.input-number-decrement,
.input-number-increment {
  display: inline-block;
  width: 30px;
  line-height: 38px;
  background: #f1f1f1;
  color: #444;
  text-align: center;
  font-weight: bold;
  cursor: pointer;

  &:active {
    background: #ddd;
  }
}

.input-number-decrement {
  border-right: none;
  border-radius: 4px 0 0 4px;
}

.input-number-increment {
  border-left: none;
  border-radius: 0 4px 4px 0;
}

// xs media queries
@media (max-width: 400px) {
  .product {
    flex-direction: column;
  }
}
</style>
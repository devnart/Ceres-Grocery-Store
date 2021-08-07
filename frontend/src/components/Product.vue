<template>
  <div class="product">
    <div class="img-container">
      <img :src="'http://localhost/ceres/backend/img/products/' + img" :alt="title" />
    </div>
    <div class="info">
      <input type="hidden" :value="pid" />
      <div class="content">
        <h3 class="product-title">{{ title }}</h3>
        <h3 class="product-price">{{ price }}$</h3>
      </div>
      <div class="quantity">
        <span @click="$emit('decrease')" class="input-number-decrement">–</span
        ><input
          class="input-number"
          type="number"
          :value="value"
          @input="$emit('input', $event.target.value)"
          min="0"
          max="10"
        /><span @click="$emit('increase')" class="input-number-increment"
          >+</span
        >
      </div>
    </div>
    <ButtonFilled @click="$emit('add')" to="" text="Add to Cart" />
  </div>
</template>

<script>
import ButtonFilled from "@/components/ButtonFilled.vue";

export default {
  components: {
    ButtonFilled,
  },
  props: {
    title: String,
    price: String,
    pid: String,
    addToCart: Function,
    value: Number,
    img: String,
  },
  data() {
    return {
      cart: {},
    };
  },
  methods: {
    local: function () {
      this.cart = {
        id: this.pid,
        name: this.title,
        Price: this.price,
      };
    },
  },
};
</script>

<style lang="scss">
$primary: #3ed749;
.product {
  background-color: #fbfbfb;
  padding: 35px;
  border-radius: 10px;
  .img-container {
    width: 180px;
    border-radius: 10px;
    overflow: hidden;
    height: 190px;
    img {
      height: 100%;
      object-fit: cover;
    }
  }

  .info {
    display: flex;
    flex-direction: column;
    margin: 10px 0;
    font-family: "Recoleta", serif;

    .content {
      display: flex;
      justify-content: space-between;
      font-family: "Recoleta", serif;
      margin-bottom: 10px;
    }
    .product-title {
      color: #9d9d9d;
    }
    .product-price {
      color: $primary;
    }
  }

  a {
    width: 100%;
    font-family: "Poppins", sans-serif;
  }
}

// Quantity
.quantity {
  text-align: center;
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
// Hide Input Arrows
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<template>
  <div class="container">
    <section class="products featured">
      <h2>{{ $route.params.category }}</h2>
      <div class="row">
        <Product
          v-for="product in products"
          :key="product.id"
          :title="product.name"
          :price="product.price"
          :value="product.qty"
          :img="product.img"
          @decrease="product.qty--"
          @increase="product.qty++"
          @add="
            $store.dispatch('addToCart', {
              product: product,
              qty: product.qty,
            })
          "
        />
      </div>
    </section>
  </div>
</template>

<script>
import Product from "@/components/Product.vue";
import axios from "axios";

export default {
  components: {
    Product,
  },
  data() {
    return {
      products: [],
      category: "",
    };
  },
  methods: {
    fetchProducts() {
      axios
        .get(
          "http://localhost/ceres/backend/productController/getProductsByCategory/" +
            this.$route.params.category
        )
        .then((response) => {
          if (response.data === false) {
            this.$router.push("/404");
          } else {
            this.products = response.data;
          }
        });
    },
  },
  created() {
    this.fetchProducts();
  },
};
</script>

<style lang="scss" scoped>
.product {
  margin-bottom: 0;
}
.products {
  margin-top: 60px;
  h2 {
    font-family: "Recoleta", serif;
    margin-bottom: 45px;
    font-size: 48px;
    text-transform: capitalize;
    text-align: center;
  }
}
.row {
  font-family: "Recoleta", serif;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 30px;
  flex-wrap: wrap;
}
</style>
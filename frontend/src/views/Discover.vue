<template>
  <div class="container">
    <section class="products featured">
      <h2>Featured Products</h2>
      <div class="row">
        <Product
          v-for="product in featuredProducts"
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
    <section class="products vegetables">
      <div class="section-header">
        <div>
          <h2>Fresh Vegetables</h2>
        </div>
        <div
          class="see-more"
          @click="
            $router.push({
              name: 'Category',
              params: { category: 'vegetables' },
            })
          "
        >
          <img src="@/assets/img/icons/arrow-right.svg" alt="" />
        </div>
      </div>
      <div class="row">
        <Product
          v-for="product in filteredProductsByVegetables"
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
    <section class="products fruits">
      <div class="section-header">
        <div>
          <h2>Delicious Fruits</h2>
        </div>
        <div
          class="see-more"
          @click="
            $router.push({ name: 'Category', params: { category: 'fruits' } })
          "
        >
          <img src="@/assets/img/icons/arrow-right.svg" alt="" />
        </div>
      </div>
      <div class="row">
        <Product
          v-for="product in filteredProductsByFruits"
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

export default {
  components: {
    Product,
  },
  mounted() {
    this.$store.dispatch("getProducts");
    console.log(this.$store.state.products);
  },
  computed: {
    featuredProducts() {
      return this.$store.state.products.filter(
        (product) => product.featured == true
      );
    },
    filteredProductsByVegetables() {
      let product = this.$store.state.products.filter(
        (product) => product.category === "vegetables"
      );
      let sliced = product.slice(0, 8);
      return sliced;
    },
    filteredProductsByFruits() {
      let product = this.$store.state.products.filter(
        (product) => product.category === "fruits"
      );
      let sliced = product.slice(0, 8);
      return sliced;
    },
  },
};
</script>

<style lang="scss" scoped>
$primary: #3ed749;

.products {
  margin-top: 60px;
  h2 {
    font-family: "Recoleta", serif;
    margin-bottom: 15px;
    font-size: 28px;
  }
}

.product {
  margin-bottom: 0;
}
.row {
  font-family: "Recoleta", serif;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 20px;
  flex-wrap: wrap;
}
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

// xs media queries
@media (max-width: 580px) {
  .row {
    gap: 10px;
  }
  .product {
    padding: 25px;
  }
}
</style>
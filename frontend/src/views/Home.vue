<template>
  <div class="home">
    <div class="hero container row" :class="mq.xs ? 'f-col text-center' : ''">
      <transition name="fade" appear>
        <div class="column" :class="mq.xs ? 'mb' : ''">
          <p>For You To Prepare At Home.</p>
          <h1 :style="mq.sm ? 'font-size: 44px;' : ''">
            Food service that delivers freshly.
          </h1>
          <ButtonFilled to="/about" text="Read More" />
        </div>
      </transition>
      <transition name="slide-right" appear>
        <div class="column">
          <img src="@/assets/img/hero.png" alt="Delivery Man" />
        </div>
      </transition>
    </div>

    <section class="about">
      <div class="row" :class="mq.xs ? 'f-col' : ''">
        <div class="col">
          <h2>Delivering the best to the best!</h2>
        </div>
        <div class="col">
          <p>From the field to your hands.</p>
          <h2>What is Our Mission?</h2>
          <p>
            The freshness of the produce being delivered to you is
            unquestionable, even in the case of standard delivery. Veggies like
            banana stem and banana flower, which are used in exotic dishes, are
            fresh and readily available to buy online at bigbasket. Vegetables
            like mushrooms and sprouts, which are prone to quick spoilage are
            also packed with utmost care using the best materials.
          </p>
        </div>
      </div>
    </section>
    <section class="products container popular" v-if="getProducts">
      <h2>Recently Added</h2>
      <div class="row" :style="mq.xs ? 'gap: 10px' : ''">
        <Product
          :style="mq.xs ? 'padding: 25px' : ''"
          v-for="product in filteredProducts"
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
    <section class="products container fruits">
      <h2>Fruits</h2>
      <div class="row">
        <Product
          :style="mq.xs ? 'padding: 25px' : ''"
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
    <section class="products container vegetables">
      <h2>Vegetables</h2>
      <div class="row">
        <Product
          :style="mq.xs ? 'padding: 25px' : ''"
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
  </div>
</template>

<script>
// @ is an alias to /src
import ButtonFilled from "@/components/ButtonFilled.vue";
import Product from "@/components/Product.vue";

export default {
  inject: ["mq"],
  name: "Home",

  components: {
    ButtonFilled,
    Product,
  },
  data() {
    return {
      products: this.$store.state.products,
      show: false,
    };
  },
  methods: {},
  computed: {
    getProducts() {
      this.products = this.$store.state.products;
      return this.products;
    },
    filteredProducts() {
      return this.products.slice(0, 4);
    },

    filteredProductsByFruits() {
      let product = this.products.filter(
        (product) => product.category === "fruits"
      );
      let sliced = product.slice(0, 4);
      return sliced;
    },
    filteredProductsByVegetables() {
      let product = this.products.filter(
        (product) => product.category === "vegetables"
      );
      let sliced = product.slice(0, 4);
      return sliced;
    },
  },
  mounted() {
    this.$store.dispatch("getProducts");
    this.show = true;
  },
};
</script>


<style scoped lang="scss">
$primary: #3ed749;

.slide-right-enter-active,
.slide-right-leave-active {
  transition: all 0.8s ease-in-out;
}
.slide-right-enter-from, .slide-right-leave-to /* .fade-leave-active below version 2.1.8 */ {
  transform: translateX(100%);
  opacity: 0;
}
.fade-enter-active,
.fade-leave-active {
  transition: all 0.8s ease-in-out;
}
.fade-enter-from, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  transform: translateX(-100%);
  opacity: 0;
}
.row {
  font-family: "Recoleta", serif;
  display: flex;
  align-items: center;
}
.column {
  flex: 1;
  p {
    margin-top: 0;
    font-size: 20px;
  }
  h1 {
    margin: 10px 0 20px 0;
    font-size: 54px;
    line-height: 1;
  }
}

.about {
  margin-top: 120px;
  background: $primary;
  padding: 190px 0;
  .row {
    justify-content: center;
    gap: 20px;
    margin-top: -270px;
  }
}
.col:first-child {
  background: linear-gradient(
      180deg,
      rgba(0, 0, 0, 0) 47.95%,
      rgba(0, 0, 0, 0.53) 100%
    ),
    url(~@/assets/img/img1.jpg);
  background-size: cover;
  display: flex;
  align-items: flex-end;
}
.col {
  background-color: #ebfbec;
  width: 400px;
  height: 400px;
  border-radius: 10px;

  h2 {
    font-size: 35px;
    line-height: 1;
    color: white;
    margin: 30px 20px;
  }
}

.col:nth-child(2) {
  padding: 30px 20px;
  color: $primary;
  display: flex;
  flex-direction: column;
  justify-content: center;
  p:first-child {
    color: rgba($color: $primary, $alpha: 0.7);
  }
  h2 {
    color: inherit;
    margin: 15px 0;
  }
}
section.products {
  h2 {
    font-family: "Recoleta", serif;
    margin-bottom: 15px;
    font-size: 28px;
  }
  .row {
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
  }
}
section.products.fruits,
section.products.vegetables {
  margin-top: 60px;
}
.popular {
  margin-top: -120px;
  h2 {
    color: white;
  }
}
// xs media queries
@media (max-width: 580px) {
  .products:not(.popular) {
    margin-top: 0 !important;
  }
}
</style>
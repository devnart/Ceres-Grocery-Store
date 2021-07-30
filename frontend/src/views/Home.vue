<template>
  <div class="home container">
    <div class="hero row">
      <div class="column">
        <p>For You To Prepare At Home.</p>
        <h1>Food service that delivers freshly.</h1>
        <ButtonFilled to="/signup" text="Try it for Free!" />
      </div>
      <div class="column">
        <img src="@/assets/img/hero.png" alt="Delivery Man" />
      </div>
    </div>

    <section class="about">
      <div class="row">
        <div class="col">
          <h2>Delivering the best to the best!</h2>
        </div>
        <div class="col">
          <p>From the field to your hands.</p>
          <h2>What is Our Mission?</h2>
          <p>
            Imperdiet tristique tristique integer et enim in felis, velit.
            Ultricies massa bibendum leo vulputate. Donec nibh lectus varius leo
            eget ultrices. Turpis vel sed sed lacus, tellus odio id nec egestas.
            Nullam ante sed vestibulum egestas.
          </p>
        </div>
      </div>
    </section>
    <section class="products">
      <div class="row">
        <Product
          v-for="item in $store.state.products"
          :key="item.id"
          :title="item.name"
          :price="item.price"
          :value="item.qty"
          @decrease="item.qty--"
          @increase="item.qty++"
          @add="$store.dispatch('addToCart', { product: item, qty: item.qty })"
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
  name: "Home",
  
  components: {
    ButtonFilled,
    Product,
  },
  data() {
    return {};
  },
  methods: {},
  mounted() {
    this.$store.dispatch("getProducts");
  },
  computed: {},
};
</script>


<style scoped lang="scss">
$primary: #3ed749;
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
  margin: 120px 0;
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
.products {
  .row {
    gap: 30px;
    flex-wrap: wrap;
  }
}
</style>
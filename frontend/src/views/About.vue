<template>
  <div class="container">
    <section class="hero" :class="mq.xs ? 'mt-0' : ''">
      <div class="row">
        <h1>
          We are on a mission to take you
          <span>from the present to the future.</span>
        </h1>
      </div>
      <div class="row">
        <img src="@/assets/img/about.png" alt="" />
      </div>
    </section>
    <section class="about-us">
      <div class="row" :class="mq.xs ? 'f-col text-center' : ''">
        <div class="column" :class="mq.xs ? 'mb' : ''">
          <h2>Lorem ipsum dolor sit amet consectetur.</h2>
        </div>
        <div class="column">
          <p>
            While fresh vegetables should be a part of your everyday meals, some
            vegetables are hard to find even in the huge supermarkets in your
            area. However, the luxury of online shopping offers customers the
            comfort of relishing these veggies by ordering them from the comfort
            of their home. While beetroot, amlas, green peas, broccoli can
            easily be found in the market.
          </p>
        </div>
      </div>
    </section>
    <div style="text-align: center; margin-top: 40px">
      <ButtonFilled to="/contact" text="Contact Us" />
    </div>
  </div>
</template>

<script>
import ButtonFilled from "@/components/ButtonFilled.vue";

export default {
  inject: ["mq"],
  name: "About",
  components: {
    ButtonFilled,
  },
};
</script>

<style scoped lang="scss">
h1 {
  font-weight: 400;
  font-family: "Recoleta", serif;
  font-size: 28px;
  line-height: 1;
  text-align: center;

  span {
    display: block;
    font-weight: 700;
    font-size: 34px;
  }
}
.hero {
  display: flex;
  align-items: center;
  flex-direction: column;
  gap: 30px;
  position: relative;
  overflow: hidden;
  margin: 60px 0;
  &::after {
    display: block;
    content: "";
    width: 580px;
    height: 580px;
    background: #f6f6f6;
    position: absolute;
    border-radius: 50%;
    bottom: -240px;
    z-index: -1;
    transition: 250ms;
  }
  &:hover::after {
    width: 610px;
    height: 610px;
  }

  .row:last-child {
    width: 500px;
  }
}
.about-us {
  background: #3ed7490a;
  padding: 60px 40px;
  border-radius: 10px;
  .row {
    display: flex;
    align-items: center;
    div {
      flex: 1;
    }
    h2 {
      font-size: 29px;
      line-height: 1;
      font-family: "Recoleta", serif;
    }
    p {
      color: #adc1ae;
    }
  }
}
@media (max-width: 580px) {
  h1 {
    font-size: 23px;
    line-height: 1.05;
    span {
      margin-top: 5px;
    }
  }
}
</style>
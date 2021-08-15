<template>
  <div class="container">
    <!-- not found page -->
    <div class="row">
      <div class="column">
        <div class="page-header">
          <h1>404</h1>
        </div>
        <p>
          <strong>ooops, something wen wrong.</strong>
        </p>
        <ButtonFilled to="/" text="Go to Home" />
      </div>
    </div>
  </div>
</template>

<script>
import ButtonFilled from "@/components/ButtonFilled";

export default {
  components: {
    ButtonFilled,
  },
};
</script>

<style lang="scss" scoped>
$primary: #3ed749;
.container {
  text-align: center;
}
h1 {
  font-size: 28px;
}
p {
  font-family: "Recoleta", serif;
  margin-bottom: 10px;
}
</style>
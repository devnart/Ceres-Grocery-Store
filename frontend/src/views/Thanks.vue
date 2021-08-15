<template>
  <section>
    <h1>Thanks</h1>
    <h3>Your Order Have Been Received Successfully</h3>
    <Button to="/" text="Keep Shopping" />
  </section>
</template>

<script>
import Button from "@/components/Button";
export default {
  components: { Button },
};
</script>

<style lang="scss" scoped>
$primary: #3ed749;
section {
  text-align: center;
  margin: 40px 0;
}
h1 {
  font-size: 46px;
  color: $primary;
  font-family: "Recoleta", serif;
}

h3 {
  color: #bbb;
  margin-bottom: 50px;
  font-weight: 400;
}
</style>
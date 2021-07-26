<template>
  <router-link :to="to">{{ text }}</router-link>
</template>

<script>
export default {

  props: {
    to: String,
    text: String,
  },
};
</script>

<style scoped lang="scss">

$primary : #3ed749;
a {
  border: 2px solid $primary;
  padding: 10px 20px;
  color: $primary !important;
  border-radius: 5px;
  font-weight: 500;
  text-decoration: none;

  &:hover {
    color: white !important;
    background-color: $primary;
    transition: 200ms;
  }
}
</style>>

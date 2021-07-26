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
font-family: inherit;
    background-color: $primary;
  padding: 10px 20px;
  color: white; 
  border-radius: 5px;
  font-weight: 500;
text-decoration: none;
text-align: center;
display: inline-block;

  &:hover {
    color:$primary;
    background-color: transparent;
    transition: 200ms;
    border: 2px solid $primary;

  }
}
</style>>

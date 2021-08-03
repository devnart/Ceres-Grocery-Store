<template>
  <keep-alive>
    <component v-bind:is="layout"></component>
 </keep-alive>
</template>
<script>
import UserLayout from './layouts/UserLayout'
import AdminLayout from './layouts/AdminLayout'

export default {
  computed: {
    layout () {
      return this.$store.getters.layout
    }
  },
  components: {
    'user-layout': UserLayout,
    'admin-layout': AdminLayout,
  },
  mounted () {
    console.log(this.layout)}
  }
  
</script>


<style lang="scss">

@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap");
@import url("./assets/fonts/recoleta/stylesheet.css");

</style>

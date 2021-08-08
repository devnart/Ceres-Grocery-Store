<template>
  <div class="pagination">
    <div class="previous">
      <router-link :to="`/${page}/page/${parseInt(currentPage)  - 1}`">
        <i class="fas fa-chevron-left"></i>
      </router-link>
    </div>
    <div class="p-numbers">
      <router-link
        v-for="(item, index) in pageCount"
        :key="item"
        class="page-item"
        :to="`/${page}/page/${index + 1}`"
      >
        <span class="page-link">{{ index + 1 }}</span>
      </router-link>
    </div>
    <div class="next">
       <router-link :to="`/${page}/page/${parseInt(currentPage) + 1}`">
      <i class="fas fa-chevron-right"></i>
       </router-link>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    currentPage: {
      default: 1,
    },
    pageCount: {
      default: 1,
    },
    page: String,
  },
  mounted() {
    // string to number
    console.log(this.currentPage);
  },
};
</script>

<style lang="scss" scoped>
a:visited {
    color: inherit;
}
.pagination {
  margin-top: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
}
.previous,
.next {
  padding: 7px 10px;
  font-weight: 700;
  line-height: 1;
  border-radius: 3px;
  font-size: 14px;
  background: #e8e8e8;
  color: #a7a7a7;
}
.page-item {
  text-decoration: none;
  &:not(:last-child) {
    margin-right: 5px;
  }
  span {
    padding: 5px 10px;
    color: #212b36;
    background: transparent;
    border: 1px solid #dfe3e8;
    font-weight: 700;
    line-height: 1;
    border-radius: 3px;
    font-size: 14px;
  }
}
.router-link-active.router-link-exact-active {
  span {
    background: #3ed749;
    color: white;
  }
}
</style>
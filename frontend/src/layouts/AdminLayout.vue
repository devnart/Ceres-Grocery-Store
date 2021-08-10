<template>
  <div class="layout-wrapper" v-if="$route.name != 'AdminLogin' ">
    <aside>
      <div class="avatar">
        <img src="@/assets/img/cow.jpg" alt="{{user.name}}" />
      </div>
      <div class="side-menu">
        <ul>
          <li>
            <router-link to="/dashboard">
              <img src="@/assets/img/icons/grid.svg" alt=""
            /></router-link>
          </li>
          <li>
            <router-link to="/products/add">
              <img src="@/assets/img/icons/plus-circle.svg" alt=""
            /></router-link>
          </li>
          <li>
            <router-link to="/users">
              <img src="@/assets/img/icons/user.svg" alt=""
            /></router-link>
          </li>
          <li>
            <router-link to="/products">
              <img src="@/assets/img/icons/shopping-bag.svg" alt=""
            /></router-link>
          </li>
          <li>
            <router-link to="/orders">
              <img src="@/assets/img/icons/orders.svg" alt=""
            /></router-link>
          </li>
        </ul>
      </div>
      <div class="logout">
        <img src="@/assets/img/icons/log-out.svg" alt="logout" @click="$store.dispatch('admin_logout')" />
      </div>
    </aside>
  </div>
  <router-view :key="$route.fullPath"></router-view>
</template>

<script>
export default {
  name: 'AdminLayout',
  methods: {
  },
};
</script>

<style lang="scss" scoped>
$red: #fc573b;
$yellow: #ffb848;
$primary: #3ed749;


.pending {
  color: $yellow !important;

  &::before {
    background: $yellow !important;
  }
}
.delivered {
  color: $primary !important;

  &::before {
    background: $primary !important;
  }
}
.cancelled {
  color: $red !important;

  &::before {
    background: $red !important;
  }
}
.layout-wrapper + main {
  margin-left: 100px;
}

aside {
  width: 100px;
  height: 100vh;
  position: fixed;
  background-color: #f8f8f8;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  padding: 20px 0;

  .avatar {
    width: 46px;
    height: 46px;
    border-radius: 5px;
    overflow: hidden;

    img {
      height: 100%;
      object-fit: cover;
    }
  }
}
.side-menu {
  ul {
    display: flex;
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 5px;
    li {
      width: 46px;
      height: 46px;
      background: #eee;
      padding: 10px;
      border-radius: 5px;

    }
  }
  img {
    filter: invert(26%) sepia(17%) saturate(2%) hue-rotate(47deg)
      brightness(90%) contrast(91%);
  }
}
.logout {
  width: 46px;
  height: 46px;
  background: #fc573b;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
}
</style>
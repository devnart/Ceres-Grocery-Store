<template>
  <main>
      <div class="container">
      <section class="orders">
        <h3>Products</h3>
        <p>All products ordred by last added</p>
        <div class="table">
          <div class="tbody">
            <div class="thead">
              <div class="tr">
                <div class="th">Id</div>
                <div class="th">Name</div>
                <div class="th">Description</div>
                <div class="th">Category</div>
                <div class="th">Unit</div>
                <div class="th">Price</div>
                <div class="th">Options</div>
              </div>
            </div>
            <div class="tr" v-for="product in products" :key="product.id">
              <div class="td">
                <div class="order-info">
                  <div class="product-id">
                    <span class="id">#{{ product.id }}</span>
                  </div>
                  <div class="user-name user-avatar">
                    <img
                      class="avatar"
                      :src="'http://localhost/ceres/backend/img/products/' + product.img"
                      alt=""
                    />
                    <span class="name">{{ product.name }}</span>
                  </div>
                  <div class="product-description">
                    <span class="description">{{ product.description }}</span>
                  </div>
                  <div class="product-category">
                    <span class="category">{{product.category}}</span>
                  </div>
                  <div class="product-unit">
                    <span class="unit">{{ product.unit }}</span>
                  </div>
                  <div class="product-price">
                    <span class="price">{{ product.price }}</span>
                  </div>
                  <div class="user-option">
                    <img
                      src="@/assets/img/icons/more-horizontal.svg"
                      alt="User Info"
                      @click="
                        $router.push({ name: 'User', params: { id: order.id } })
                      "
                    />
                    <img
                      src="@/assets/img/icons/close.svg"
                      alt="User Info"
                      @click="
                        $router.push({ name: 'User', params: { id: order.id } })
                      "
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <pagination :currentPage="currentPage" :pageCount="totalPages" page="users" />
    </div>
  </main>
</template>

<script>
export default {
data () {
  return {
    currentPage: 1,
    totalPages: 0,
    products: this.$store.state.products,
  }},
mounted () {
    console.log(this.$store.state.products);
}}
</script>


<style lang="scss" scoped>
.thead {
  .tr {
    padding: 10px 0;
    .th {
      color: #000;
      font-size: 14px;
    }
  }
}
.orders {
  padding-top: 20px;
  .table {
    margin-top: 15px;
  }
  p {
    font-size: 12px;
  }
}

.orders h3 {
  margin-bottom: 0;
}

.tbody {
  background: #fcfcfc;
  padding: 15px;
  border-radius: 5px;
}
.order-info {
  padding: 15px 0;
  span {
    color: #6c6c6c;
    font-size: 14px;
  }
}
.user-id {
  flex: 0.5;
}
.user-avatar {
  display: flex;
  align-items: center;
  gap: 10px;

  .avatar {
    width: 35px;
    height: 35px;
    border-radius: 5px;
    object-fit: cover;
  }     
}
.user-option {
  display: flex;
  gap: 5px;
  justify-content: center;

  img {
    cursor: pointer;
    padding: 5px;
    background: #f6f6f6;
    border-radius: 5px;
    width: 32px;
    height: 32px;

    &:hover {
      background: #3ed749;
  }

  &:last-child {
    padding: 0;

  }
}}
</style>
<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="close-btn">X</div>
          <div class="modal-header">
            <div class="header">Edit Product {{ data.id }}</div>
          </div>

          <div class="modal-body">
            <form
              @submit.prevent="updateProduct()"
              ref="form"
              enctype="multipart/form-data"
            >
              <div class="form-group">
                <input
                  type="text"
                  id="name"
                  placeholder="Name"
                  :value="data.name"
                  name="name"
                />
              </div>
              <div class="form-group">
                <input
                  type="text"
                  id="description"
                  placeholder="Description"
                  :value="data.description"
                  name="description"
                />
              </div>
              <div class="form-group">
                <div class="boxes">
                  <label for="vegetables" @click="checkCategory('vegetables')">
                    <div class="box" ref="vegetables">
                      <img
                        src="@/assets/img/vegetables_c.png"
                        alt="Vegetables"
                      />
                    </div>
                  </label>
                  <input
                    type="radio"
                    id="vegetables"
                    name="category"
                    value="vegetables"
                    :checked="data.category == 'vegetables' ? true : false"
                  />
                  <label for="fruits" @click="checkCategory('fruits')">
                    <div class="box" ref="fruit">
                      <img src="@/assets/img/fruits_c.png" alt="Fruits" />
                    </div>
                  </label>
                  <input
                    type="radio"
                    id="fruits"
                    name="category"
                    value="fruits"
                    :checked="data.category == 'fruits' ? true : false"
                  />
                </div>
              </div>
              <div class="form-group">
                <select name="unit" id="unit">
                  <option
                    :selected="data.unit == 'kg' ? true : false"
                    value="kg"
                  >
                    kg
                  </option>
                  <option
                    :selected="data.unit == 'lot' ? true : false"
                    value="lot"
                  >
                    Lot
                  </option>
                </select>
              </div>
              <div class="form-group">
                <input
                  type="number"
                  id="price"
                  placeholder="Price"
                  :value="data.price"
                  name="price"
                />
              </div>
              <div class="form-group">
                <label for="image">
                  <div>
                    <p><span>Select a file</span> or drag in form</p>
                    <p>PNG, jpg, gif files up to 10 MB in size</p>
                  </div>
                  <img
                    class="upload-icon"
                    src="@/assets/img/icons/upload.svg"
                    alt=""
                  />
                </label>
                <input
                  :value="data.image"
                  type="file"
                  name="img"
                  id="image"
                  @change="getImage"
                />
              </div>
              <input type="submit" name="submit" value="+ Add Product" />
            </form>
          </div>

          <div class="modal-footer">
            <slot name="footer">
              default footer
              <button class="modal-default-button" @click="$emit('close')">
                OK
              </button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    data: {},
  },
  data() {
    return {
      name: "",
      description: "",
      category: "",
      price: "",
      unit: "",
      image: "",
    };
  },
  methods: {
    checkCategory(category) {
      if (category === "vegetables") {
        this.$refs.fruit.style.backgroundColor = "transparent";

        this.$refs.vegetables.style.backgroundColor = "#3ed749";
      } else if (category === "fruits") {
        this.$refs.vegetables.style.backgroundColor = "transparent";

        this.$refs.fruit.style.backgroundColor = "#3ed749";
      }
    },
  },
  mounted() {
      this.checkCategory(this.data.category)
  }
};
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
    position: relative;
  width: 600px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>
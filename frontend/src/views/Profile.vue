<template>
  <div class="main">
    <div class="container">
      <header>
        <div class="col">
          <label class="edit-avatar" for="upload-file">
            <img src="@/assets/img/icons/pencil.svg" alt="" />
          </label>
          <div class="avatar" style="display: none">
            <input
              type="file"
              name="image"
              id="upload-file"
              @change="uploadeimage"
            />
          </div>
          <div class="avatar">
            <img
              :src="'http://localhost/ceres/backend/img/' + user.avatar"
              alt=""
            />
          </div>
          <div class="info">
            <h2 class="name">{{ user.name }}</h2>
            <p class="role">{{ user.role }}</p>
          </div>
        </div>
        <div class="col">
          <ButtonFilled
            to="#"
            text="Rest Password"
            @click="toggleEditPassword"
          />
          <ButtonFilled to="#" text="Edit Profile" @click="toggleEditProfile" />
        </div>
      </header>
      <section class="edit">
        <!-- edit profile -->
        <div class="edit-profile-content" v-if="isEditProfile">
          <form class="edit-profile-form" @submit.prevent="editProfile">
            <div class="edit-profile-form-input">
              <label for="name">Name</label>
              <input
                required
                type="text"
                class="edit-profile-form-input-name"
                placeholder="Name"
                v-model="user.name"
              />
            </div>
            <div class="edit-profile-form-input">
              <label for="email">Email</label>
              <input
                required
                type="email"
                class="edit-profile-form-input-email"
                placeholder="Email"
                v-model="user.email"
              />
            </div>
            <div class="edit-profile-form-input">
              <Submit text="Update" />
            </div>
          </form>
        </div>

        <div class="edit-profile-content" v-if="isEditPassword">
          <form class="edit-profile-form" @submit.prevent="editPassword">
            <div class="edit-profile-form-input">
              <label for="name">Old Password</label>
              <input
                required
                type="password"
                class="edit-profile-form-input-password"
                placeholder="Password"
                v-model="oldPassword"
              />
            </div>
            <div class="edit-profile-form-input">
              <label for="email">New Password</label>
              <input
                required
                type="password"
                class="edit-profile-form-input-password-confirm"
                placeholder="New Password"
                v-model="newPassword"
              />
            </div>
            <div class="edit-profile-form-input">
              <label for="email">Confirm Password</label>
              <input
                required
                type="password"
                class="edit-profile-form-input-password-confirm"
                placeholder="Repeat New Password"
                v-model="confirmPassword"
              />
            </div>
            <div class="edit-profile-form-input">
              <Submit text="Update Password" />
            </div>
          </form>
        </div>
      </section>
      <section class="orders">
        <h3>My Orders</h3>
        <div class="table">
          <div class="thead">
            <div class="tr">
              <div class="th">Id</div>
              <div class="th orders">Orders</div>
              <div class="th date">Date</div>
              <div class="th adress">Adress</div>
              <div class="th">Total</div>
              <div class="th">Status</div>
              <div class="th">Cancel</div>
            </div>
          </div>

          <div class="tbody">
            <div class="tr" v-for="order in orders" :key="order.id">
              <div class="td">
                <div class="order-info">
                  <div class="order-number">
                    <span class="number">#{{ order.id }}</span>
                  </div>
                  <div class="order-title">
                    <span class="title">{{ order.products }}</span>
                  </div>
                  <div class="order-date">
                    <span class="date">{{ order.created }}</span>
                  </div>
                  <div class="order-adress">
                    <span class="adress">{{ order.adress }}</span>
                  </div>
                  <div class="order-price">
                    <span class="price">{{ order.totalPrice }}</span>
                  </div>
                  <div class="order-status">
                    <span
                      class="status"
                      :class="{
                        delivered: order.status == 'delivered',
                        pending: order.status == 'pending',
                        cancelled: order.status == 'rejected',
                        cancelled: order.status == 'cancelled',
                      }"
                      >{{ order.status }}</span
                    >
                  </div>
                  <div class="delete-order">
                    <img
                      v-if="order.status == 'pending'"
                      src="@/assets/img/icons/close.svg"
                      alt="Cancel Order"
                      @click="cancelOrder(order.id)"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import ButtonFilled from "@/components/ButtonFilled.vue";
import Submit from "@/components/Submit.vue";

import { createToast } from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";

import axios from "axios";

export default {
  components: {
    ButtonFilled,
    Submit,
  },
  data() {
    return {
      orders: [],
      user: {},
      isEditProfile: false,
      isEditPassword: false,
      newPassword: "",
      confirmPassword: "",
      oldPassword: "",
    };
  },
  methods: {
    // upload avatar
    uploadeimage(file) {
      console.log(file);
      const formData = new FormData();
      formData.append("uploadfile", file.target.files[0]);
      axios
        .post(
          `http://localhost/ceres/backend/UserController/updateAvatar/${this.user.id}`,
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        )
        .then((response) => {
          if (response.data == "unauthorized Token") {
            this.$store.dispatch('checkJWT')
          } else {
            this.getUser();
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    toggleEditProfile() {
      this.isEditPassword = false;

      this.isEditProfile = !this.isEditProfile;
    },
    toggleEditPassword() {
      this.isEditProfile = false;
      this.isEditPassword = !this.isEditPassword;
    },

    // change password
    editPassword() {
      const config = {
        headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
      };

      if (this.newPassword !== this.confirmPassword) {
        createToast("new Password Didn't Macth", {
          showIcon: true,
          swipeClose: true,
          position: "bottom-center",
          type: "danger",
          transition: "slide",
          timeout: 4000,
        });
      } else {
        axios
          .put(
            "http://localhost/ceres/backend/UserController/updatePassword/" +
              this.user.id,
            {
              newPassword: this.newPassword,
              oldPassword: this.oldPassword,
            },
            config
          )
          .then((response) => {
            console.log(response.data);
            if (response.data != "success") {
              createToast(response.data, {
                showIcon: true,
                swipeClose: true,
                position: "bottom-center",
                type: "danger",
                transition: "slide",
                timeout: 4000,
              });
            } else {
              this.isEditPassword = false;

              createToast("Password Updated Successfully", {
                showIcon: true,
                swipeClose: true,
                position: "bottom-center",
                type: "success",
                transition: "slide",
                timeout: 4000,
              });
            }
          })
          .catch((error) => {
            alert("Error: " + error.response.data.message);
          });
      }
    },
    // update profile
    editProfile() {
      const config = {
        headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
      };
      axios
        .put(
          "http://localhost/ceres/backend/UserController/update/" +
            this.user.id,
          {
            name: this.user.name,
            email: this.user.email,
          },
          config
        )
        .then((response) => {
          console.log(response.data);
          if (response.data != "success") {
            createToast(response.data, {
              showIcon: true,
              swipeClose: true,
              position: "bottom-center",
              type: "danger",
              transition: "slide",
              timeout: 4000,
            });
          } else {
            this.isEditProfile = false;
            createToast("Profile Updated Successfully", {
              showIcon: true,
              swipeClose: true,
              position: "bottom-center",
              type: "success",
              transition: "slide",
              timeout: 4000,
            });
          }
        })
        .catch((error) => {
          alert("Error: " + error.response.data.message);
        });
    },

    // get user data
    getUser() {
      const id = localStorage.getItem("user_id");
      axios
        .post("http://localhost/ceres/backend/UserController/getUser", { id })
        .then((response) => {
          this.user = response.data;
          this.$store.commit("SET_USER", this.user);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getOrderByUid() {
      const userId = localStorage.getItem("user_id");
      // get product by uid
      // with axios post
      axios
        .post(
          "http://localhost/ceres/backend/OrderController/getOrdersByUserId",
          { userId }
        )
        .then((response) => {
          this.orders = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    // cancel order
    cancelOrder(orderId) {
      axios
        .post("http://localhost/ceres/backend/OrderController/cancelOrder", {
          orderId,
        })
        .then((response) => {
          console.log(response.data);
          this.getOrderByUid();
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getUser();
    this.$store.dispatch("checkJWT");
    this.getOrderByUid();
  },
};
</script>

<style lang='scss' scoped>
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
.main {
  padding: 60px 0;
  background: #f5f5f5;
}
header {
  margin-bottom: 70px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  .col:first-child {
    display: flex;
    align-items: center;
    gap: 20px;

    h2 {
      font-family: "Recoleta", serif;
      font-size: 2em;
    }
    p {
      color: #b3b3b3;
      font-style: italic;
    }
  }
  .col:last-child {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }
}

.col:first-child {
  position: relative;
}
.edit-avatar {
  width: 30px;
  height: 30px;
  padding: 6px;
  position: absolute;
  top: 0;
  left: 10px;
  cursor: pointer;
  background: $primary;
  border-radius: 40px;
}
.avatar {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  overflow: hidden;

  img {
    height: 100%;
    object-fit: cover;
  }
}

.edit-profile-form {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 50px 0;
  justify-content: center;

  div {
    display: flex;
    flex-direction: column;
    gap: 5px;
    &:last-child {
      align-self: flex-end;
    }
  }
}

.orders {
  h3 {
    margin-bottom: 10px;
  }
}
.thead {
  .tr {
    color: #c1c1c1;
    padding: 10px 20px;
    text-align: center;
    display: flex;

    div {
      flex: 1;
    }
    .orders,
    .date {
      flex: 2;
    }
    .adress {
      flex: 3;
    }
  }
}
.tbody {
  display: flex;
  flex-direction: column;
  gap: 5px;
}
.order-info {
  text-align: center;
  font-weight: 500;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px;
  border-radius: 5px;
  background: #fff;
  box-shadow: rgba(15, 15, 15, 0.1) 0px 2px 4px;
  div {
    flex: 1;
  }
  .order-title,
  .order-date {
    flex: 2;
  }
  .order-adress {
    flex: 3;
  }
  .status {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;

    &::before {
      content: "";
      display: block;
      background: $yellow;
      width: 10px;
      height: 10px;
      border-radius: 50px;
    }
  }
  .delete-order {
    display: flex;
    justify-content: center;
    img {
      width: 32px;
      height: 32px;
    }
  }
}
</style>
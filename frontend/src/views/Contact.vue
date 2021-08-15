<template>
  <div class="container">
    <div class="header">
      <h1>Contact Us</h1>
      <p>Have a question? need some helo? don't hesitate to contact us.</p>
    </div>
    <div class="contact-form">
      <form>
        <div class="row" :class="mq.xs ? 'f-col' : ''">
          <div class="form-group">
            <div>
              <input type="text" id="name" placeholder="Name" />
            </div>
          </div>
          <div class="form-group">
            <div>
              <input type="email" id="email" placeholder="Email" />
            </div>
          </div>
        </div>
        <div class="row" :class="mq.xs ? 'f-col' : ''">
          <div class="form-group">
            <div>
              <input type="tel" id="phone" placeholder="Phone" />
            </div>
          </div>
          <div class="form-group">
            <div>
              <input type="text" id="subject" placeholder="Subject" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <div>
              <textarea rows="8" id="message" placeholder="Message"></textarea>
            </div>
          </div>
        </div>
        <div class="" style="text-align: center">
          <div>
            <Submit text="Send!" />
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Submit from "@/components/Submit.vue";

export default {
  inject: ["mq"],

  components: {
    Submit,
  },
};
</script>

<style lang="scss" scoped>
.header {
  margin: 20px 0;
  text-align: center;
  h1 {
    font-size: 2em;
    font-weight: bold;
    font-family: "Recoleta", serif;
  }
  p {
    color: #c1c1c1;
  }
}
.contact-form {
  margin-top: 60px;
}
.row {
  display: flex;
  gap: 12px;
  margin-bottom: 12px;
  &:last-child {
    margin-bottom: 0;
  }
  .form-group {
    flex: 1;
    div {
      textarea,
      input:not(input[readonly]) {
        width: 100%;
        border: 1px solid rgb(173, 173, 173);
        box-shadow: none;
        font-family: inherit;
      }
    }
  }
}
</style>
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import { Vue3Mq } from "vue3-mq";

const app = createApp(App);

app.use(router);
app.use(store);
app.use(Vue3Mq);

app.mount("#app");

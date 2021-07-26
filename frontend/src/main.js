import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'


const app = createApp(App);

app.config.globalProperties.isAuthenticated = false;
app.use(router).use(store).mount('#app')


import './bootstrap';
import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index'
import store from './store/index'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'
import errorHandlingAxios from './utils/errorHandlingAxios'
import Pusher from "pusher-js";

const app = createApp(App)

app.use(router)
app.use(store)
app.use(Toast)
app.config.globalProperties.$pusher = new Pusher(
    "d214ea7b4c891f668a32",
    {
        cluster: "ap1",
    }
);
app.config.globalProperties.$helpers = { errorHandlingAxios}

app.mount('#app')


import { createApp } from "vue";
import { createPinia } from "pinia";

import App from "./App.vue";
import router from "./router";

import "./assets/main.css";

const pusherKey = import.meta.env.VITE_PUSHER_APP_KEY,
    pusherCluster = import.meta.env.VITE_PUSHER_APP_CLUSTER

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

if (pusherKey && pusherCluster) {
    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: pusherKey,
        cluster: pusherCluster,
        forceTLS: true
    });
}

const app = createApp(App);

app.use(createPinia());
app.use(router);

app.mount("#app");

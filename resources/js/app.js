import App from './App.vue';
import {createApp} from 'vue';
import {createRouter, createWebHistory} from 'vue-router';
import { routes } from './routes';
const router = createRouter({
    history: createWebHistory(),
    routes: routes
});
createApp(App)
.use(router)
.mount('#app')
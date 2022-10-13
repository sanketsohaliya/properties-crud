import App from './App.vue';
import {createApp} from 'vue';
import {createRouter, createWebHistory} from 'vue-router';
import { routes } from './routes';
import VueGoodTablePlugin from 'vue-good-table-next';
import 'vue-good-table-next/dist/vue-good-table-next.css'
const router = createRouter({
    history: createWebHistory(),
    routes: routes
});
createApp(App)
.use(router)
.use(VueGoodTablePlugin)
.mount('#app')
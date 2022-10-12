import AllProperty from './components/AllProperty.vue';
import CreateProperty from './components/CreateProperty.vue';
import EditProperty from './components/EditProperty.vue';
 
export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllProperty
    },
    {
        name: 'create',
        path: '/create',
        component: CreateProperty
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditProperty
    }
];
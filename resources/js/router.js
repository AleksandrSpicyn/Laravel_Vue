import VueRouter from 'vue-router';
import Products from './components/Products';

export default new VueRouter({
    routes: [
        {
            path: '/',
            component: Products
        }
    ],
    mode: 'history'
});
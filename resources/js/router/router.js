import { createRouter, createWebHistory } from 'vue-router';
import HomeRouter from '../Pages/HomeRouter.vue';
import Checkout from '../Pages/Checkout.vue';
import Login from '../Pages/Login.vue';
import OrderConfirmation from '../Pages/OrderConfirmation.vue';

const routes = [
    {
        path: "/login",
        name: "login",
        component: Login,
    },
    {
        path: "/",
        name: "home",
        component: HomeRouter,
        meta: { requiresAuth: true },
    },
    {
        path: "/order/confirmation/:id",
        name: "order-confirmation",
        component: OrderConfirmation,
        meta: { requiresAuth: true },
    },
    {
        path: "/checkout",
        name: "checkout",
        component: Checkout,
        meta: { requiresAuth: true },
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

function isAuthenticated() {
    return !!localStorage.getItem('user-token');
}

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!isAuthenticated()) {
            next({ path: '/login' });
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;

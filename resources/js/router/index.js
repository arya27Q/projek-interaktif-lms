import { createRouter, createWebHistory } from 'vue-router';
import Login from '../modules/auth/views/Login.vue';
import Register from '../modules/auth/views/Register.vue';
import ForgotPassword from '../modules/auth/views/ForgotPassword.vue';

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/forgot-password',
        name: 'ForgotPassword',
        component: ForgotPassword
    },
    {
        // Default route to redirect to login for now
        path: '/',
        redirect: '/login'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;

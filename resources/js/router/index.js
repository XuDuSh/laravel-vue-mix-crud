import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import About from '../pages/About';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';

import Payments from "../components/Payments";
import AddPayment from "../components/AddPayment";

import Users from "../components/Users";
import AddUser from "../components/AddUser";
import EditUser from "../components/EditUser";
import PaymentHistory from "../components/PaymentHistory";

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'about',
        path: '/about',
        component: About
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'payments',
        path: '/payments',
        component: Payments
    },
    {
        name: 'addpayment',
        path: '/payments/add',
        component: AddPayment
    },
    {
        name: 'users',
        path: '/users',
        component: Users
    },
    {
        name: 'adduser',
        path: '/users/add',
        component: AddUser,
    },
    {
        name: 'edituser',
        path: '/users/edit/:id',
        component: EditUser
    },
    {
        name: 'paymenthistory',
        path: '/users/:id/payments',
        component: PaymentHistory
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;

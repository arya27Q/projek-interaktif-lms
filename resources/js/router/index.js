import { createRouter, createWebHistory } from 'vue-router';
import Login from '../modules/auth/views/Login.vue';
import Register from '../modules/auth/views/Register.vue';
import ForgotPassword from '../modules/auth/views/ForgotPassword.vue';

import UserLayout from '../layouts/UserLayout.vue';
import Dashboard from '../modules/user/views/Dashboard.vue';
import Profile from '../modules/user/views/Profile.vue';
import Achievements from '../modules/user/views/Achievements.vue';
import EditProfile from '../modules/user/views/EditProfile.vue';
import ChangePassword from '../modules/user/views/ChangePassword.vue';
import TwoFactorAuth from '../modules/user/views/TwoFactorAuth.vue';
import PrivacySettings from '../modules/user/views/PrivacySettings.vue';

import Catalog from '../modules/course/views/Catalog.vue';
import InstructorStudio from '../modules/course/views/InstructorStudio.vue';
import CoursePlayer from '../modules/course/views/CoursePlayer.vue';

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
        path: '/',
        component: UserLayout,
        children: [
            {
                path: '',
                name: 'Dashboard',
                component: Dashboard
            },
            {
                path: 'catalog',
                name: 'Catalog',
                component: Catalog
            },
            {
                path: 'instructor',
                name: 'InstructorStudio',
                component: InstructorStudio
            },
            {
                path: 'course/:id',
                name: 'CoursePlayer',
                component: CoursePlayer
            },
            {
                path: 'courses',
                name: 'MyCourses',
                component: CoursePlayer
            },
            {
                path: 'profile',
                name: 'Profile',
                component: Profile
            },
            {
                path: 'profile/achievements',
                name: 'Achievements',
                component: Achievements
            },
            {
                path: 'profile/edit',
                name: 'EditProfile',
                component: EditProfile
            },
            {
                path: 'profile/settings/password',
                name: 'ChangePassword',
                component: ChangePassword
            },
            {
                path: 'profile/settings/2fa',
                name: 'TwoFactorAuth',
                component: TwoFactorAuth
            },
            {
                path: 'profile/settings/privacy',
                name: 'PrivacySettings',
                component: PrivacySettings
            }
        ]
    },
    {
        // Default route to redirect to login for now
        path: '/',
        redirect: '/login'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { top: 0 }
        }
    }
});

export default router;

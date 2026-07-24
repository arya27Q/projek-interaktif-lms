import { createRouter, createWebHistory } from 'vue-router';

// ─── Layout (tetap eager — dibutuhkan segera di semua halaman) ───
import UserLayout from '../layouts/UserLayout.vue';

// ─── Semua halaman menggunakan lazy loading ─────────────────────
// Vite akan otomatis split menjadi chunk terpisah (code splitting)
// sehingga browser hanya download JS halaman yang sedang dibuka.

const Login          = () => import('../modules/auth/views/Login.vue');
const Register       = () => import('../modules/auth/views/Register.vue');
const ForgotPassword = () => import('../modules/auth/views/ForgotPassword.vue');

const Dashboard      = () => import('../modules/user/views/Dashboard.vue');
const Profile        = () => import('../modules/user/views/Profile.vue');
const Achievements   = () => import('../modules/user/views/Achievements.vue');
const EditProfile    = () => import('../modules/user/views/EditProfile.vue');
const ChangePassword = () => import('../modules/user/views/ChangePassword.vue');
const TwoFactorAuth  = () => import('../modules/user/views/TwoFactorAuth.vue');
const PrivacySettings = () => import('../modules/user/views/PrivacySettings.vue');
const UpgradePro     = () => import('../modules/user/views/UpgradePro.vue');

const Catalog          = () => import('../modules/course/views/Catalog.vue');
const InstructorStudio = () => import('../modules/course/views/InstructorStudio.vue');
const CoursePlayer     = () => import('../modules/course/views/CoursePlayer.vue');

// ─── Route definitions ────────────────────────────────────────────
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
                component: () => import('../modules/course/views/CoursePlayer.vue')
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
            },
            {
                path: 'upgrade',
                name: 'UpgradePro',
                component: UpgradePro
            }
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        }
        return { top: 0 };
    }
});

export default router;

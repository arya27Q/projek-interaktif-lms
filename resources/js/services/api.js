/**
 * api.js — Service Layer untuk komunikasi dengan backend
 *
 * Semua request HTTP ke Laravel API dipusatkan di sini.
 * Komponen & store TIDAK boleh memanggil fetch/axios langsung.
 * Ganti BASE_URL dengan URL API Laravel kamu.
 */

const BASE_URL = import.meta.env.VITE_API_URL ?? '/api';

// ─── HTTP Helper ──────────────────────────────────────────────────

async function request(method, endpoint, body = null, options = {}) {
    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...options.headers,
    };

    // Ambil token dari localStorage (untuk Sanctum / JWT)
    const token = localStorage.getItem('auth_token');
    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    const config = {
        method,
        headers,
    };

    if (body) {
        config.body = JSON.stringify(body);
    }

    const response = await fetch(`${BASE_URL}${endpoint}`, config);

    // Handle token expired / unauthorized
    if (response.status === 401) {
        localStorage.removeItem('auth_token');
        window.location.href = '/login';
        return;
    }

    if (!response.ok) {
        const error = await response.json().catch(() => ({ message: 'Server error' }));
        throw new Error(error.message ?? `HTTP Error ${response.status}`);
    }

    // Kembalikan null jika respons kosong (misal: 204 No Content)
    const text = await response.text();
    return text ? JSON.parse(text) : null;
}

const get    = (url, options)        => request('GET', url, null, options);
const post   = (url, body, options)  => request('POST', url, body, options);
const put    = (url, body, options)  => request('PUT', url, body, options);
const patch  = (url, body, options)  => request('PATCH', url, body, options);
const del    = (url, options)        => request('DELETE', url, null, options);

// ─── Auth ─────────────────────────────────────────────────────────
export const authApi = {
    login:          (credentials)  => post('/auth/login', credentials),
    register:       (data)         => post('/auth/register', data),
    logout:         ()             => post('/auth/logout'),
    forgotPassword: (email)        => post('/auth/forgot-password', { email }),
    resetPassword:  (data)         => post('/auth/reset-password', data),
    me:             ()             => get('/auth/me'),
};

// ─── Courses ──────────────────────────────────────────────────────
export const courseApi = {
    // Daftar semua kursus (dengan filter opsional)
    // Contoh: courseApi.getAll({ category: 'Computer Science', page: 1 })
    getAll: (params = {}) => {
        const query = new URLSearchParams(params).toString();
        return get(`/courses${query ? `?${query}` : ''}`);
    },

    // Detail satu kursus
    getById:    (id)                 => get(`/courses/${id}`),

    // Cari kursus
    search:     (keyword)            => get(`/courses/search?q=${encodeURIComponent(keyword)}`),

    // Kursus yang sedang diikuti user
    getMyCourses: ()                 => get('/courses/my'),

    // Enroll ke kursus
    enroll:     (courseId)           => post(`/courses/${courseId}/enroll`),

    // Tandai pelajaran selesai
    completeLesson: (courseId, lessonId) => patch(`/courses/${courseId}/lessons/${lessonId}/complete`),

    // Progress
    getProgress: (courseId)          => get(`/courses/${courseId}/progress`),
};

// ─── User / Profile ───────────────────────────────────────────────
export const userApi = {
    getProfile:     ()               => get('/user/profile'),
    updateProfile:  (data)           => put('/user/profile', data),
    changePassword: (data)           => put('/user/password', data),
    getAchievements: ()              => get('/user/achievements'),
    getActivity:    ()               => get('/user/activity'),
    update2FA:      (data)           => post('/user/2fa', data),
    updatePrivacy:  (data)           => put('/user/privacy', data),
};

// ─── Gamification ─────────────────────────────────────────────────
export const gamificationApi = {
    getLeaderboard: (period = 'weekly') => get(`/gamification/leaderboard?period=${period}`),
    getStreak:      ()                   => get('/gamification/streak'),
    getBadges:      ()                   => get('/gamification/badges'),
    claimBadge:     (badgeId)            => post(`/gamification/badges/${badgeId}/claim`),
};

// ─── Catalog ──────────────────────────────────────────────────────
export const catalogApi = {
    getCategories:    ()              => get('/catalog/categories'),
    getFeatured:      ()              => get('/catalog/featured'),
    getByCategory:    (slug, params)  => {
        const query = new URLSearchParams(params).toString();
        return get(`/catalog/${slug}${query ? `?${query}` : ''}`);
    },
};

// ─── Quiz ─────────────────────────────────────────────────────────
export const quizApi = {
    getQuiz:        (quizId)          => get(`/quizzes/${quizId}`),
    submitAnswer:   (quizId, data)    => post(`/quizzes/${quizId}/answer`, data),
    getResult:      (attemptId)       => get(`/quizzes/attempts/${attemptId}`),
};

// ─── Default export (opsional, untuk penggunaan umum) ─────────────
export default {
    auth:         authApi,
    course:       courseApi,
    user:         userApi,
    gamification: gamificationApi,
    catalog:      catalogApi,
    quiz:         quizApi,
};

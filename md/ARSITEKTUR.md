# 📘 Catatan Arsitektur & Optimasi — NexLearn LMS

> Dibuat: 24 Juli 2026 | Baca ini kalau lupa cara kerja struktur proyek

---

## 🗂️ Struktur Folder Frontend

```
resources/js/
├── app.js                  ← Entry point Vue
├── App.vue                 ← Root component
├── router/
│   └── index.js            ← Definisi semua route (LAZY LOADING)
├── layouts/
│   └── UserLayout.vue      ← Shell layout (sidebar, header, nav)
├── services/
│   └── api.js              ← Semua HTTP request ke Laravel API
├── data/
│   └── mockCourses.js      ← Data dummy sementara (nanti diganti API)
├── modules/
│   ├── auth/views/         ← Login, Register, ForgotPassword
│   ├── user/views/         ← Dashboard, Profile, Achievements, dll
│   ├── course/views/       ← Catalog, CoursePlayer, InstructorStudio
│   ├── course-player/
│   │   ├── components/     ← VideoPlayer, PopupQuiz
│   │   └── store/          ← coursePlayerStore.js
│   └── gamification/
│       ├── components/     ← Leaderboard, StreakWidget
│       └── store/          ← gamificationStore.js
└── components/             ← Komponen global (shared)
```

---

## ⚡ Lazy Loading Router

### Masalah sebelumnya
Semua komponen halaman diimport langsung di atas file router:
```js
// ❌ Buruk — semua JS halaman didownload sekaligus saat pertama buka app
import Dashboard from '../modules/user/views/Dashboard.vue';
import Catalog from '../modules/course/views/Catalog.vue';
// ...dst (12 halaman sekaligus!)
```
Akibatnya: **initial load lambat**, apalagi kalau ada banyak data dan halaman baru.

### Solusi yang sudah diterapkan
```js
// ✅ Bagus — masing-masing halaman baru didownload saat user navigasi ke sana
const Dashboard = () => import('../modules/user/views/Dashboard.vue');
const Catalog   = () => import('../modules/course/views/Catalog.vue');
```

### Cara kerjanya
- Vite otomatis memecah bundle JS menjadi **chunk terpisah** per halaman
- Browser hanya download chunk halaman yang sedang dibuka
- Halaman lain didownload di background / saat pertama kali dikunjungi
- Hasilnya: **app pertama kali buka jadi jauh lebih cepat** ✅

> **Aturan:** Kalau menambah halaman baru, **selalu gunakan arrow function** `() => import(...)`, bukan `import ... from ...` di baris paling atas.

---

## 🔌 Service Layer — `services/api.js`

### Kenapa perlu file ini?
Tanpa service layer, kalau kamu fetch data langsung di komponen:
```js
// ❌ Buruk — URL API tersebar di mana-mana, susah diubah kalau ganti endpoint
const res = await fetch('http://localhost:8000/api/courses');
```

Dengan service layer, semua panggilan API terpusat:
```js
// ✅ Bersih — cukup ubah api.js kalau endpoint berubah
import { courseApi } from '@/services/api.js';
const courses = await courseApi.getAll({ category: 'Design' });
```

### Fitur yang sudah ada di `api.js`

| Fitur | Keterangan |
|---|---|
| Auto Bearer Token | Token dari `localStorage` otomatis dikirim di setiap request |
| Auto redirect login | Kalau server balas `401 Unauthorized`, langsung redirect ke `/login` |
| Error handling | Semua error server ditangkap dan dilempar sebagai `Error` dengan pesan yang jelas |
| Grup endpoint | Endpoint dikelompokkan per fitur agar mudah dicari |

### Daftar semua endpoint yang tersedia

#### 🔐 `authApi`
```js
import { authApi } from '@/services/api.js';

authApi.login({ email, password })   // POST /auth/login
authApi.register(data)               // POST /auth/register
authApi.logout()                     // POST /auth/logout
authApi.forgotPassword(email)        // POST /auth/forgot-password
authApi.me()                         // GET  /auth/me (info user yang login)
```

#### 📚 `courseApi`
```js
import { courseApi } from '@/services/api.js';

courseApi.getAll({ category, page }) // GET  /courses?category=...&page=...
courseApi.getById(id)                // GET  /courses/:id
courseApi.search('keyword')          // GET  /courses/search?q=...
courseApi.getMyCourses()             // GET  /courses/my
courseApi.enroll(courseId)           // POST /courses/:id/enroll
courseApi.completeLesson(cId, lId)   // PATCH /courses/:id/lessons/:id/complete
courseApi.getProgress(courseId)      // GET  /courses/:id/progress
```

#### 👤 `userApi`
```js
import { userApi } from '@/services/api.js';

userApi.getProfile()                 // GET  /user/profile
userApi.updateProfile(data)          // PUT  /user/profile
userApi.changePassword(data)         // PUT  /user/password
userApi.getAchievements()            // GET  /user/achievements
```

#### 🏆 `gamificationApi`
```js
import { gamificationApi } from '@/services/api.js';

gamificationApi.getLeaderboard('weekly') // GET /gamification/leaderboard?period=weekly
gamificationApi.getStreak()              // GET /gamification/streak
gamificationApi.getBadges()              // GET /gamification/badges
```

#### 🎯 `quizApi`
```js
import { quizApi } from '@/services/api.js';

quizApi.getQuiz(quizId)              // GET  /quizzes/:id
quizApi.submitAnswer(quizId, data)   // POST /quizzes/:id/answer
quizApi.getResult(attemptId)         // GET  /quizzes/attempts/:id
```

---

## 🔧 Konfigurasi URL API

URL base API diambil dari file `.env`:
```env
VITE_API_URL=http://localhost:8000/api
```

- **Development (lokal):** `http://localhost:8000/api`
- **Production (server):** ganti dengan URL domain kamu, misal `https://nexlearn.id/api`

> **Penting:** Variabel di `.env` yang bisa dibaca Vue/Vite **harus diawali `VITE_`**. Kalau tidak, variabelnya tidak akan terbaca di frontend.

---

## 🚀 Cara Integrasi API ke Store (Contoh)

Saat data dummy sudah siap diganti dengan data asli dari Laravel:

```js
// modules/course/store/courseStore.js
import { defineStore } from 'pinia';
import { courseApi } from '@/services/api.js';

export const useCourseStore = defineStore('course', {
  state: () => ({
    courses: [],
    isLoading: false,
    error: null,
  }),
  actions: {
    async fetchCourses(filters = {}) {
      this.isLoading = true;
      try {
        // Ganti mockCourses dengan ini:
        this.courses = await courseApi.getAll(filters);
      } catch (err) {
        this.error = err.message;
      } finally {
        this.isLoading = false;
      }
    }
  }
});
```

---

## 📝 Aturan & Konvensi

1. **Komponen tidak boleh fetch langsung** — selalu lewat `services/api.js`
2. **Store adalah perantara** antara API dan komponen
3. **Route baru = selalu lazy load** dengan `() => import(...)`
4. **Data dummy di `data/`** hanya untuk development, hapus setelah API siap
5. **Token auth** disimpan di `localStorage` dengan key `auth_token`

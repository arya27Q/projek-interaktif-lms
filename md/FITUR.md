# 🚀 Rangkuman Fitur & Status Sistem — NexLearn LMS

Dokumen ini merangkum seluruh fitur yang direncanakan di dalam **Product Requirements Document (PRD)** beserta status pengerjaannya (fokus Frontend UI/UX).

> **Legenda:**
> ✅ **Selesai (Frontend UI/UX)**
> ⏳ **Menunggu Integrasi Backend / Sedang Dikerjakan**

---

## 1. Core Engine (Sistem Dasar)

### 🔐 Otentikasi & Manajemen Akun
*   ✅ **Login & Register:** Antarmuka dengan dukungan form modern.
*   ✅ **Lupa Password:** Alur input email dan reset password.
*   ✅ **Pengaturan Profil:** Edit data diri, ubah avatar, ubah password, dan pengaturan privasi.
*   ✅ **Autentikasi 2 Faktor (2FA):** Antarmuka aktivasi keamanan ganda menggunakan kode QR dan aplikasi authenticator.
*   ⏳ **Role Management (Admin/Instructor/Student):** Routing dan proteksi halaman masih disimulasikan di frontend, menunggu middleware backend.

### 📚 Penelusuran & Navigasi
*   ✅ **Katalog Kursus:** Tampilan daftar kursus (grid layout) lengkap dengan sistem *filter* (Kategori, Harga, Rating, Level) dan pencarian responsif.
*   ✅ **Global Search Bar:** Kolom pencarian di navigasi atas (header) yang menampilkan menu *dropdown* hasil pencarian secara instan (*mockup data*).
*   ✅ **Sidebar Dinamis:** Menu navigasi utama (Dashboard, Katalog, Profil) dengan state aktif.

---

## 2. Advanced Interactive Video Player

Semua fitur ini tergabung dalam halaman **Course Player**.

*   ✅ **Theater Mode Layout:** Tata letak 70% area video dan 30% area sidebar multifungsi.
*   ✅ **In-Video Pop-up Quiz:** Kuis yang menghentikan video pada detik tertentu (overlay kuis) dan wajib dijawab sebelum lanjut.
*   ✅ **Timestamped Notes:** Fitur penulisan catatan di sidebar. Saat catatan dikirim, otomatis mengunci timestamp video saat itu. (Jika diklik, seharusnya video melompat ke detik tersebut).
*   ✅ **Time-Synced Discussion:** Kolom Q&A (Tanya Jawab) antar siswa/instruktur di mana setiap pertanyaan yang diajukan otomatis memiliki tautan (*anchor*) ke durasi spesifik video.

---

## 3. Adaptive Learning Logic

Logika kecerdasan sistem untuk memandu siswa secara dinamis.

*   ✅ **Visual Indicators (UI):** Tampilan visual di daftar Modul/Materi.
    *   `Bypass Badge`: Modul dilompat (Otomatis selesai) karena skor Pre-test awal > 90.
    *   `Remedial Badge`: Modul khusus yang terbuka saat nilai kuis siswa < 60.
    *   `Locked State`: Modul tidak dapat diklik sebelum syarat sebelumnya terpenuhi.
*   ⏳ **Branching Engine (Backend):** Logika aktual penentuan skor dan penguncian/pembukaan modul perlu dihubungkan dengan database/API.

---

## 4. Gamification & Retention Engine

Mesin pendorong motivasi siswa agar terus belajar.

*   ✅ **Daily Streak Tracker:** *Widget* api menyala di header dan Dashboard yang menghitung hari login berturut-turut.
*   ✅ **Leaderboard Global:** Papan peringkat mingguan (Top 10) berdasarkan akumulasi poin EXP.
*   ✅ **EXP System:** Tampilan perolehan EXP di profil, dashboard, dan sidebar.
*   ✅ **Achievement Badges:** Halaman koleksi lencana/badge 3D (cth: "Night Owl", "Speed Learner") dengan status *Locked* dan *Unlocked*.

---

## 5. Peer-to-Peer & Manual Assessment

Sistem tugas akhir dan penugasan kolaboratif.

*   ✅ **Pengumpulan Tugas (Peer Review):** Halaman khusus tugas yang memungkinkan siswa menautkan prototipe eksternal (Figma/Web) atau mengunggah file ZIP/PDF.
*   ✅ **Penilaian Silang (Cross-Review):** Antarmuka di mana siswa harus menilai secara anonim (menggunakan range slider) tugas milik 2 siswa lain, lengkap dengan kolom komentar dan indikator *rubrik penilaian*.
*   ✅ **Sertifikat Kelulusan:** Desain premium halaman sertifikat digital (Lulus Sangat Baik, Tanggal, Nomor ID) dengan dukungan resolusi layar adaptif dan tombol "Unduh PDF" & "Bagikan".

---

## 6. Instructor Studio

*   ✅ **Dashboard Analitik Kreator:** Tampilan khusus instruktur (kreator kursus) yang memuat visualisasi metrik penting seperti Total Pendapatan, Tingkat Retensi Video (Drop-off Rate), dan Kesehatan Kursus (Review & Kuis).
*   ✅ **Manajemen Kursus Aktif:** Tabel daftar kursus yang dimiliki instruktur beserta performa pendapatan dan status publikasinya.

---

## 7. Fitur Monetisasi / Langganan (Upgrade)

*   ✅ **Pricing Page (Upgrade ke Pro):** Halaman komersial penawaran paket langganan (Gratis, Pro, Tim) dengan tombol geser penagihan Bulanan/Tahunan.
*   ✅ **Feature Comparison Table:** Tabel perbandingan mendetail tentang apa yang didapatkan user jika beralih ke paket langganan berbayar.

---

## Ringkasan Integrasi Teknis (Frontend)

| Komponen | Implementasi | Status |
| :--- | :--- | :--- |
| **Framework Utama** | Vue 3 + Tailwind CSS | ✅ Siap (Responsive) |
| **State Management** | Pinia (Modules: Auth, Course, Gamification) | ✅ Terpusat |
| **Routing** | Vue Router (Lazy Loading & Code Splitting) | ✅ Teroptimasi |
| **API Client** | Axios (Service Layer Pattern di `services/api.js`) | ✅ Menunggu API Backend |
| **Environment** | `.env` variables (`VITE_API_URL`) | ✅ Disetup |

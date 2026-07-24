# Product Requirements Document (PRD)

**Project Name:** NexLearn (Advanced Interactive LMS)  
**Platform:** Web Application (Responsive Desktop & Mobile)  
**Tech Stack:** Laravel (Backend API), Vue 3 + Vite (Frontend SPA), PostgreSQL (Database)

## 1. Visi & Tujuan Sistem
NexLearn adalah Learning Management System (LMS) generasi modern yang mengubah paradigma belajar dari "menonton pasif" menjadi "interaksi aktif".
- **Masalah yang Diselesaikan:** Tingkat penyelesaian (completion rate) kursus online tradisional sangat rendah (seringkali di bawah 15%) karena membosankan.
- **Solusi (UVP):** Menggunakan injeksi interaktivitas di dalam video player, jalur belajar yang beradaptasi dengan kecerdasan siswa (Adaptive Learning), serta mesin gamifikasi untuk memicu retensi psikologis (habit-building).

## 2. Target Pengguna (User Personas)
- **Siswa (Student):** Pengguna akhir yang mengkonsumsi materi, berburu poin EXP, dan berinteraksi di forum.
- **Instruktur (Instructor):** Kreator konten yang mengunggah video, membuat titik kuis pop-up, dan menilai tugas akhir.
- **Administrator:** Pengelola platform yang memantau transaksi, server, dan mencabut/memberikan akses pengguna.

## 3. Fitur Utama & Modul Spesifik (Scope of Work)

### A. Core Engine (Sistem Dasar)
- **Authentication & Role Management:** Login/Register standar dengan JWT/Sanctum dan pembatasan akses berbasis Role (Admin, Instruktur, Siswa).
- **Course Catalog & Payment:** Halaman pencarian kursus dengan filter (kategori, harga, rating) dan integrasi Payment Gateway untuk pendaftaran (enrollment).

### B. Advanced Interactive Video Player
- **In-Video Pop-up Quiz:** Menghentikan laju video secara otomatis pada timestamp tertentu dan memaksa siswa menjawab pertanyaan sebelum bisa melanjutkan.
- **Timestamped Notes:** Siswa dapat mengetik catatan digital. Sistem otomatis menyimpan timestamp video saat itu, berfungsi sebagai shortcut navigasi (klik catatan, video melompat ke waktu tersebut).
- **Time-Synced Discussion:** Kolom komentar (Q&A) yang berlabuh pada detik video spesifik, memudahkan konteks pertanyaan teknis.

### C. Adaptive Learning Logic
- **Pre-test Bypass:** Kuis di awal pendaftaran. Jika skor > 90, sistem otomatis menandai materi dasar sebagai Completed dan membuka kunci materi lanjutan.
- **Automated Remedial:** Logika percabangan (branching). Jika nilai kuis akhir modul < 60, materi bab berikutnya akan dikunci, dan siswa otomatis diarahkan ke video/kuis remedial yang sebelumnya disembunyikan.

### D. Gamification & Retention Engine
- **Daily Streak Tracker:** Menghitung login harian berturut-turut. Streak pecah jika absen 1x24 jam.
- **EXP & Leaderboard:** Mendapatkan +10 EXP per video selesai, +50 EXP per tugas lulus. Ditampilkan di klasemen mingguan Global dan per-Kursus.
- **Achievement Badges:** Sistem reward otomatis berdasarkan pemicu (contoh: Badge "Night Owl" untuk penyelesaian materi di atas jam 12 malam).

### E. Peer-to-Peer & Manual Assessment
- **File Submission:** Pengunggahan file tugas akhir (PDF/ZIP/GitHub link).
- **Cross-Review:** Penugasan otomatis agar tugas Siswa A dinilai silang oleh 2 siswa acak lainnya menggunakan rubrik yang disediakan, sebelum nilai dikonfirmasi oleh instruktur.

## 4. Arsitektur Teknis & Alur Sistem

| Komponen | Teknologi Pilihan | Peran & Fungsi Utama |
| --- | --- | --- |
| Frontend | Vue 3 (Composition API) + Pinia | Me-render SPA, mengatur interaksi video player khusus, dan state management. |
| Backend API | Laravel 11 | Menangani logika bisnis, adaptive routing, validasi kuis, kalkulasi EXP, integrasi payment. |
| Database | PostgreSQL | Menyimpan relasi kompleks (users, courses, interactions, gamification stats). |
| Real-time | Laravel Reverb / Pusher | Memancarkan notifikasi real-time saat ada balasan di forum diskusi time-synced. |
| Background | Redis + Laravel Horizon | Memproses email sertifikat kelulusan & kalkulasi Leaderboard mingguan di belakang layar. |

## 5. Skema Database (Entitas Utama)
Sistem menggunakan pendekatan relasional murni dengan tambahan tabel metrik interaksi.

### Tabel Akademik & Konten
| Tabel | Kolom Kunci Utama |
| --- | --- |
| `courses` | id, instructor_id, title, price, status |
| `modules` | id, course_id, title, order_index, is_remedial |
| `lessons` | id, module_id, title, type (video/quiz/text), media_url |
| `video_interactions` | id, lesson_id, timestamp_trigger, quiz_payload (JSON) |

### Tabel Pengguna & Progres
| Tabel | Kolom Kunci Utama |
| --- | --- |
| `enrollments` | id, user_id, course_id, progress_percent, status |
| `quiz_attempts` | id, user_id, lesson_id, score, is_passed |
| `user_bookmarks` | id, user_id, lesson_id, timestamp, note_text |
| `discussions` | id, user_id, lesson_id, timestamp_context, message |

### Tabel Gamifikasi
| Tabel | Kolom Kunci Utama |
| --- | --- |
| `gamification_stats` | id, user_id, current_streak, total_exp, rank_tier |
| `earned_badges` | id, user_id, badge_name, earned_at |

## 6. Desain UI/UX & User Journey
Tema antarmuka berfokus pada "Clean Modern Education" dengan penggunaan whitespace yang luas dan palet warna yang memotivasi (Biru/Ungu untuk fokus, Oranye/Kuning untuk gamifikasi/pencapaian).

- **A. Student Dashboard (Vue View):** Hero Section menampilkan kursus yang sedang aktif berjalan dengan Progress Bar. Gamification Panel menampilkan ikon api (Streak Count), level saat ini, total EXP, dan peringkat Leaderboard minggu ini.
- **B. Interactive Course Player (Vue Component):** Layout Teater mode. Video mendominasi 70% sisi kiri layar. 30% sisi kanan adalah tab dinamis (Daftar Materi / Catatan Timestamp / Diskusi). Video Overlay untuk kuis pop-up. Animasi hujan kertas (confetti) setelah modul selesai.
- **C. Instructor Studio (Vue View):** Halaman khusus kreator yang berisi metrik analitik: Drop-off rate dan menu timeline editor untuk menyisipkan titik kuis pada video.

## 7. Kebutuhan Non-Fungsional (NFR)
- **Video Delivery:** Video harus di-streaming menggunakan protokol HLS (HTTP Live Streaming) atau di-host di penyedia pihak ketiga (seperti Vimeo Pro / AWS MediaConvert) agar sulit dibajak dan resolusi beradaptasi dengan koneksi.
- **API Security:** Menerapkan Rate Limiting (pembatasan request) pada rute pengiriman (submit) kuis untuk mencegah manipulasi skor gamifikasi menggunakan bot.

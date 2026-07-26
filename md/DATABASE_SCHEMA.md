# 🗄️ Skema Database & Fungsi Kolom — NexLearn LMS

Dokumen ini memuat detail struktur tabel-tabel di dalam database beserta penjelasan rinci mengenai fungsi masing-masing kolom untuk mendukung fitur-fitur canggih NexLearn (seperti Gamifikasi, Video Interaktif, dan *Peer Review*).

---

## 1. Tabel Inti & Pengguna (Core & Users)

### `users`
Menyimpan data otentikasi dan profil semua pengguna (Siswa, Instruktur, Admin).
*   **`id`** (PK): ID unik pengguna.
*   **`name`** / **`email`** / **`password`**: Data login standar.
*   **`role`** (enum): `'admin'`, `'instructor'`, `'student'`. Menentukan hak akses di aplikasi.
*   **`avatar_url`** (string): Tautan URL foto profil pengguna.
*   **`bio`** (text): Deskripsi singkat profil pengguna.
*   **`two_factor_secret`**, **`two_factor_recovery_codes`**, **`two_factor_confirmed_at`**: Konfigurasi keamanan Autentikasi 2 Faktor (2FA).

### `subscriptions`
Menyimpan status paket langganan premium pengguna.
*   **`id`** (PK).
*   **`user_id`** (FK): Pengguna yang berlangganan.
*   **`plan_name`** (string): Nama paket (misal: 'Pro', 'Team').
*   **`expires_at`** (timestamp): Tanggal kedaluwarsa langganan.
*   **`status`** (enum): `'active'`, `'expired'`, `'cancelled'`.

---

## 2. Tabel Katalog & Materi Kursus

### `courses`
Menyimpan informasi master dari sebuah kursus.
*   **`id`** (PK).
*   **`instructor_id`** (FK -> users): Kreator kursus.
*   **`title`** (string): Judul kursus.
*   **`category`** (string): Kategori kursus (misal: Pemrograman, Desain) untuk fitur Filter.
*   **`level`** (enum): `'beginner'`, `'intermediate'`, `'advanced'`.
*   **`thumbnail_url`** (string): URL gambar poster kursus.
*   **`price`** (decimal): Harga beli satuan kursus.
*   **`average_rating`** (decimal): Rata-rata rating bintang untuk performa query yang cepat.
*   **`status`** (enum): `'draft'`, `'published'`.

### `modules`
Bab atau pengelompokan materi dalam sebuah kursus.
*   **`id`** (PK).
*   **`course_id`** (FK): Relasi ke kursus.
*   **`title`** (string): Judul modul.
*   **`order_index`** (integer): Urutan modul.
*   **`is_remedial`** (boolean): Jika `true`, modul ini disembunyikan dan hanya muncul kalau nilai kuis siswa jelek.

### `lessons`
Materi belajar individual di dalam modul (Video, Teks, Kuis).
*   **`id`** (PK).
*   **`module_id`** (FK): Relasi ke modul.
*   **`title`** (string): Judul materi.
*   **`type`** (enum): `'video'`, `'quiz'`, `'text'`, `'assignment'`.
*   **`media_url`** (string): Tautan file video atau dokumen.

### `video_interactions`
Menyimpan titik interaksi (Pop-up Quiz) di dalam video.
*   **`id`** (PK).
*   **`lesson_id`** (FK): ID materi video.
*   **`timestamp_trigger`** (integer): Detik ke-berapa video harus dijeda otomatis.
*   **`quiz_payload`** (JSON): Menyimpan pertanyaan, pilihan jawaban, dan penjelasan dalam format JSON.

---

## 3. Tabel Interaksi & Aktivitas Belajar

### `discussions`
Menyimpan forum Q&A yang tersinkronisasi dengan waktu video (*Time-Synced*).
*   **`id`** (PK).
*   **`user_id`** (FK): Siswa yang bertanya/menjawab.
*   **`lesson_id`** (FK): Video tempat pertanyaan diajukan.
*   **`parent_id`** (FK -> discussions, nullable): Jika diisi, ini berarti baris ini adalah **balasan** dari komentar lain (*nested replies*).
*   **`timestamp_context`** (integer): Penanda detik video saat pertanyaan dibuat.
*   **`message`** (text): Isi komentar/pertanyaan.
*   **`upvotes_count`** (integer): Jumlah 'Jempol/Suka' dari siswa lain.

### `user_bookmarks`
Catatan pribadi siswa di detik video tertentu.
*   **`id`** (PK).
*   **`user_id`** (FK).
*   **`lesson_id`** (FK).
*   **`timestamp`** (integer): Detik video di-bookmark.
*   **`note_text`** (text): Isi catatan.

### `video_watch_logs`
Catatan analitik seberapa jauh siswa menonton video (untuk mengukur *Drop-off Rate*).
*   **`id`** (PK).
*   **`user_id`** (FK).
*   **`lesson_id`** (FK).
*   **`watched_seconds`** (integer): Total durasi tonton aktif kumulatif.
*   **`max_timestamp_reached`** (integer): Detik terjauh video yang berhasil ditonton (menghindari siswa skip-skip video langsung ke akhir).

---

## 4. Tabel Progres & Gamifikasi

### `enrollments`
Mencatat pendaftaran siswa ke sebuah kursus.
*   **`id`** (PK).
*   **`user_id`** (FK).
*   **`course_id`** (FK).
*   **`progress_percent`** (integer): Persentase penyelesaian kursus (0-100%).
*   **`status`** (enum): `'active'`, `'completed'`.

### `gamification_stats`
Mencatat poin dan *streak* harian siswa.
*   **`id`** (PK).
*   **`user_id`** (FK).
*   **`current_streak`** (integer): Jumlah hari beruntun login tanpa putus.
*   **`total_exp`** (integer): Total akumulasi *Experience Points* untuk Leaderboard.
*   **`rank_tier`** (string): Peringkat (misal: 'Bronze', 'Silver', 'Gold').
*   **`last_login_date`** (timestamp): Penentu algoritma apakah hari ini *streak* bertambah, berlanjut, atau hangus ke 0.

### `earned_badges`
Menyimpan lencana penghargaan yang berhasil diraih siswa.
*   **`id`** (PK).
*   **`user_id`** (FK).
*   **`badge_name`** (string): Nama badge (misal: 'Night Owl', 'Speed Learner').
*   **`earned_at`** (timestamp): Kapan badge ini didapat.

---

## 5. Tabel Penugasan & Peer Review

### `assignments`
Instruksi tugas akhir dari instruktur.
*   **`id`** (PK).
*   **`lesson_id`** (FK).
*   **`instructions`** (text): Instruksi pengerjaan.
*   **`rubric_json`** (JSON): Kriteria penilaian (Rubrik) dalam bentuk JSON (contoh: Kerapian=30%, Logika=70%).

### `submissions`
Tugas yang dikumpulkan oleh siswa.
*   **`id`** (PK).
*   **`assignment_id`** (FK).
*   **`user_id`** (FK): Siswa pengumpul tugas.
*   **`file_url`** (string): URL/Link tugas (Figma, GitHub, PDF, ZIP).
*   **`status`** (enum): `'submitted'` (Menunggu dinilai), `'reviewed'` (Selesai dinilai).

### `peer_reviews`
Penilaian silang antar siswa.
*   **`id`** (PK).
*   **`submission_id`** (FK): Tugas yang dinilai.
*   **`reviewer_id`** (FK -> users): Siswa yang bertugas menilai.
*   **`score`** (integer): Nilai yang diberikan.
*   **`feedback_comment`** (text): Komentar saran/kritik membangun dari penilai.

---

## 6. Tabel Keuangan & Transaksi

### `transaction` (atau `transactions`)
Mencatat riwayat pembayaran pembelian kursus tunggal (integrasi Midtrans).
*   **`id`** (PK).
*   **`midtrans_order_id`** (string, unique): ID Order yang di-generate sistem LMS (cth: TRX-001) untuk dikirim ke Midtrans.
*   **`transaction_id`** (string, nullable): ID asli dari server Midtrans (diisi otomatis melalui Webhook saat pembayaran berhasil).
*   **`amount`** (decimal): Jumlah pembayaran (Rupiah).
*   **`payment_method`** (string): Metode bayar (cth: 'gopay', 'bca_va').
*   **`status`** (enum): `'pending'`, `'success'`, `'failed'`.
*   **`user_id`** (FK): Siswa yang membeli.
*   **`course_id`** (FK): Kursus yang dibeli.

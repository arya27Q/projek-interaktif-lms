# 🔄 Alur Sistem (System Flow) — NexLearn LMS

Dokumen ini memetakan alur kerja utama (*workflows*) dari berbagai modul dalam sistem LMS NexLearn. Mulai dari pengguna mendaftar, membeli kursus, hingga mekanisme belajar yang adaptif dan interaktif.

---

## 1. Alur Pendaftaran & Keamanan Akun
1. **Pendaftaran (Register):** Pengguna (Siswa/Instruktur) mendaftar menggunakan email dan password.
2. **Setup Profil & 2FA:** Pengguna diarahkan ke pengaturan profil untuk mengatur identitas, avatar, dan opsi Autentikasi 2 Faktor (2FA) menggunakan aplikasi Authenticator (Google/Microsoft).
3. **Login:** Jika 2FA aktif, pengguna wajib memasukkan 6 digit kode dari aplikasi setelah memasukkan email & password.

---

## 2. Alur Pembelian Kursus & Langganan
1. **Eksplorasi Katalog:** Pengguna menjelajahi katalog kursus menggunakan fitur filter dinamis (Kategori, Level, Harga).
2. **Checkout Pembelian:**
   - **Beli Satuan:** Pengguna klik beli, sistem men-generate `midtrans_order_id`, memanggil antarmuka Midtrans, dan merubah status transaksi menjadi `pending`.
   - **Upgrade Langganan (Pro/Tim):** Pengguna memilih paket di halaman Pricing, mendaftar ke *Subscription Plan*.
3. **Konfirmasi (Webhook):** Midtrans mengirimkan notifikasi (*webhook*) ke *backend* bahwa pembayaran sukses. Sistem memperbarui status menjadi `success`, mengisi `transaction_id`, dan membuka akses kursus ke siswa melalui tabel `enrollments`.

---

## 3. Alur Pembelajaran Cerdas (*Adaptive Learning*)
1. **Pre-test Assessment:** Begitu siswa masuk ke kursus pertama kali, mereka disuguhi "Kuis Penempatan". Jika skor > 90, modul dasar otomatis dilompati (*bypassed*) dan siswa langsung melaju ke materi lanjutan.
2. **Menonton Materi Video:** Siswa menekan *Play*. Setiap detik direkam secara diam-diam oleh *Analytics Engine* (disimpan di `video_watch_logs`) untuk menghitung *Drop-off Rate*.
3. **In-Video Pop-up Quiz:** Di detik/menit tertentu, video **dijeda paksa** oleh sistem, dan muncul layar kuis (Tebak ganda / Benar Salah) yang menutupi layar. Siswa wajib menjawab dengan benar sebelum video bisa dilanjutkan.
4. **Alur Remedial Otomatis:** Di akhir modul, terdapat Evaluasi Modul. Jika nilai ujian < 60, materi bab berikutnya akan dikunci, dan sistem memunculkan Modul Tambahan (*Remedial*) yang sebelumnya berstatus `is_remedial=true`.

---

## 4. Alur Interaksi Komunitas (*Time-Synced Discussion*)
1. **Membuat Catatan Timestamp:** Saat menonton, siswa mencatat di sidebar "Catatan". Sistem otomatis mengambil timestamp (misal: 02:45). Saat besoknya siswa klik catatan tersebut, video langsung melompat tepat ke detik 02:45.
2. **Diskusi Tersinkronisasi:**
   - Siswa A tidak paham sebuah konsep pada menit 08:20, dia beralih ke tab "Diskusi" dan mem-posting pertanyaan.
   - Postingan otomatis ditempel label `[08:20]`.
   - Instruktur atau Siswa B mengklik postingan tersebut, lalu video mereka **terputar otomatis di menit 08:20** agar mereka mengerti konteks visual apa yang sedang ditanyakan.
3. **Validasi Kualitas:** Postingan yang bagus bisa di-*upvote* (like) oleh komunitas dan bisa di-balas berlapis (*nested replies*).

---

## 5. Alur Penugasan Kolaboratif (*Cross-Peer Review*)
1. **Instruksi Tugas:** Instruktur mem-posting instruksi tugas akhir beserta Rubrik Penilaian (misal: Desain UI=40%, UX=60%).
2. **Pengumpulan Tugas (*Submission*):** Siswa mengunggah link Figma/Github atau PDF ke dalam sistem. Status berubah menjadi `submitted`.
3. **Distribusi Acak:** Mesin (*Backend*) membagikan tugas Siswa A secara acak (anonim) kepada Siswa B dan Siswa C untuk dinilai.
4. **Penilaian Silang:** Siswa B & C menilai menggunakan sistem slider sesuai rubrik yang diberikan instruktur, dan memberikan *feedback* membangun.
5. **Kalkulasi & Kelulusan:** Sistem menghitung rata-rata nilai silang. Jika lolos, Sertifikat Digital eksklusif (dengan ID unik) terbit otomatis.

---

## 6. Alur Retensi & Gamifikasi
1. **Daily Streak:** Setiap siswa login, *backend* mengecek `last_login_date`. Jika selisihnya tepat 1 hari, poin *Streak* bertambah (contoh: 🔥 12 Hari). Jika lebih dari 48 jam, *streak* hangus jadi 0.
2. **EXP & Leaderboard:** Siswa mendapat +10 EXP setiap menonton video sampai selesai, +50 EXP setiap Pop-up Quiz benar, dsb. Akumulasi poin menentukan peringkat tier (*Bronze, Silver, Gold*) di Klasemen Global.
3. **Achievement Badges:** Sistem *cron job* mengecek kondisi. Jika siswa menyelesaikan materi jam 2 pagi, sistem langsung menganugerahkan lencana 3D *Night Owl* di profil mereka.

---

## 7. Alur Instruktur (Kreator)
1. **Manajemen Kursus:** Melalui halaman Instructor Studio, instruktur menambah modul, mengunggah video, dan mengatur letak detik *Pop-up Quiz*.
2. **Dashboard Analitik:** Instruktur bisa memantau *Kesehatan Kursus*. Sistem mengolah data `video_watch_logs` untuk menampilkan grafik di menit ke-berapa siswa paling banyak kabur (berhenti menonton).
3. **Pencairan Pendapatan:** Total akumulasi pembelian dari tabel `transaction` masuk ke *wallet* instruktur, dan bisa dicairkan (*withdrawal*) setiap akhir bulan.

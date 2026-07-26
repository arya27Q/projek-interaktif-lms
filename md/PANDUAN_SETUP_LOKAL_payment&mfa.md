# 🛠️ Panduan Setup & Testing Fitur (Gratis di Localhost)

Dokumen ini menjelaskan bagaimana caranya melakukan pengaturan (*setup*) dan pengujian (*testing*) untuk fitur-fitur kompleks seperti **Payment Gateway (Midtrans)** dan **Autentikasi 2 Faktor (2FA)** secara **100% GRATIS** tanpa harus membeli server/hosting terlebih dahulu. Semua dapat berjalan langsung di lingkungan pengembangan lokal (Localhost / Laragon).

---

## 1. Integrasi Payment Gateway (Midtrans) 💳

Biasanya, payment gateway memerlukan website yang sudah *live* di internet agar mereka bisa mengirimkan konfirmasi pembayaran (via Webhook). Namun, kita bisa mengakalinya secara gratis di localhost.

### A. Menggunakan Midtrans Sandbox
Midtrans menyediakan lingkungan **Sandbox** (Uji Coba) khusus untuk developer.
1. **Daftar Akun:** Buat akun gratis di [Midtrans Sandbox](https://simulator.sandbox.midtrans.com/).
2. **Kunci Akses (Keys):** Dapatkan `Server Key` dan `Client Key` dari dashboard Midtrans, lalu masukkan ke dalam file `.env` Laravel kamu:
   ```env
   MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxx
   MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxx
   MIDTRANS_IS_PRODUCTION=false
   ```
3. **Uang Palsu:** Midtrans memberikan simulator nomor kartu kredit, e-wallet (GoPay, ShopeePay), dan Virtual Account palsu. Jadi, saat mengetes checkout di aplikasimu, kamu tidak akan mengeluarkan uang sepeserpun.

### B. Menerima Webhook di Localhost (Pakai Ngrok)
Midtrans butuh cara untuk "mengetuk" pintu backend Laravel kamu (Localhost) untuk memberitahu bahwa *user* A sudah sukses membayar. Karena localhost tidak punya domain publik, kita gunakan alat bantu gratis bernama **Ngrok**.

1. **Install Ngrok:** Download dari ngrok.com.
2. **Jalankan Ngrok:** Buka terminal dan ketik perintah berikut untuk menghubungkan port Laragon kamu (biasanya port 8000 jika pakai `php artisan serve`):
   ```bash
   ngrok http 8000
   ```
3. **Dapatkan Domain Publik:** Ngrok akan memberikan URL seperti `https://a1b2c3d4.ngrok-free.app`.
4. **Pasang di Midtrans:** Masukkan URL tersebut ke menu *Payment Notification URL* di dashboard Midtrans Sandbox (contoh: `https://a1b2c3d4.ngrok-free.app/api/webhooks/midtrans`).
5. **Sukses!** Sekarang setiap kali kamu melakukan tes pembayaran di *frontend*, Midtrans akan mengirimkan data sukses/gagal lewat jalur Ngrok langsung ke komputermu.

---

## 2. Autentikasi 2 Faktor (2FA / MFA) 🔐

Untuk sistem 2FA, antarmuka kita menggunakan model **TOTP** (*Time-based One-Time Password*) yang menggunakan *barcode* (QR Code). Ini jauh lebih baik dan **Gratis 100%** dibandingkan menggunakan OTP via SMS.

### A. Cara Kerja TOTP (Tanpa Biaya SMS)
1. **Tidak Ada Pihak Ketiga Berbayar:** TOTP bekerja murni menggunakan rumus matematika (kriptografi) yang mencocokkan waktu (jam/menit) di server (komputermu) dengan waktu di HP pengguna.
2. **Sepenuhnya Lokal & Offline:** Saat fitur 2FA diaktifkan, Laravel Fortify (atau package `pragmarx/google2fa-laravel`) akan membuat **Secret Key** acak. Kunci ini kemudian diubah menjadi gambar QR Code dan ditampilkan ke layar pengguna.
3. Proses pembuatan kunci dan validasi ini sepenuhnya terjadi di *server/localhost* kamu secara gratis.

### B. Cara Testing di Localhost
1. Saat user mengaktifkan 2FA di halaman Profil, layar akan memunculkan QR Code.
2. Kamu (sebagai tester) cukup mengunduh aplikasi gratis **Google Authenticator** atau **Microsoft Authenticator** di HP-mu (via Play Store / App Store).
3. Buka aplikasinya, dan arahkan kamera HP ke QR Code yang ada di layar komputermu.
4. Aplikasi akan mengeluarkan 6 digit kode acak (yang berubah setiap 30 detik).
5. Masukkan 6 digit kode tersebut ke kolom di websitemu untuk mengonfirmasi. Validasi ini akan berhasil meskipun aplikasi kamu berjalan murni di `http://localhost`.

### C. Fallback (Recovery Codes)
Sebagai standar keamanan, saat 2FA diaktifkan, sistem akan meng-generate `recovery_codes` (sekumpulan kode teks statis) yang akan disimpan di database. Jika HP tester hilang/rusak, mereka masih bisa login menggunakan kode darurat ini. Ini juga berjalan 100% secara lokal.

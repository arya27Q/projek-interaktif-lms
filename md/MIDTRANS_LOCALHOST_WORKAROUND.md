# 💡 Trik Integrasi Midtrans di Localhost (Tanpa Ngrok/Hosting)

Secara standar, *Payment Gateway* seperti Midtrans memerlukan website yang sudah di-hosting (punya domain publik seperti `.com`) untuk bisa mengirimkan **Webhook**. Webhook ini adalah "kurir" dari Midtrans yang bertugas mengetuk pintu *backend* (Laravel) kita untuk memberi tahu: *"Pesanan nomor 123 sudah dibayar lunas nih!"*.

Karena aplikasi kita masih berjalan di `localhost` (komputer lokal yang tidak bisa diakses internet), Midtrans tidak akan bisa mengirimkan Webhook tersebut.

## Solusi Cerdas: Memanfaatkan Frontend Callback + Verifikasi Backend

Untuk mengakali hal ini tanpa perlu aplikasi tambahan seperti Ngrok, kita akan menggunakan cara berikut:

1. **User Klik Bayar:** Pengguna menekan tombol "Bayar" di aplikasi Vue kita. Vue meminta `Snap Token` ke Laravel.
2. **Pop-up Midtrans Muncul:** Vue memanggil `window.snap.pay(token)`. Layar pop-up pembayaran asli milik Midtrans akan muncul. Pengguna melakukan simulasi pembayaran (misal pakai QRIS atau BCA Virtual Account Sandbox).
3. **Frontend Mendapat Notifikasi Cepat:** Begitu pembayaran di pop-up berhasil, pop-up akan otomatis menutup dan Midtrans akan memicu fungsi (callback) `onSuccess` di kode Vue kita.
4. **Vue Melapor ke Laravel:** Vue langsung berteriak ke Laravel: *"Bro, pengguna barusan udah berhasil bayar pesanan nomor 123!"*
5. **Laravel Melakukan Verifikasi Silang (Keamanan):** Karena laporan dari Vue (Frontend) bisa saja di-hack atau dimanipulasi oleh *user* usil, Laravel tidak boleh langsung percaya. Laravel akan diam-diam mengirim *request* ke API Server Midtrans: *"Halo Midtrans, tolong cek status pesanan 123 dong, beneran udah lunas belum?"*
6. **Status Diperbarui:** Jika Midtrans menjawab "Benar, sudah Settlement/Lunas", maka Laravel akan mengubah status pesanan di database kita menjadi **LUNAS**. Pengguna bisa langsung mengakses kursusnya.

### Keuntungan Cara Ini:
*   **100% Berjalan di Localhost:** Tidak butuh Ngrok, tidak butuh hosting.
*   **Aman (Secure):** Validasi tetap dilakukan dari server ke server (Laravel ke Midtrans), sehingga tidak bisa di-bypass oleh pengguna.
*   **Siap Masuk Production:** Kode ini tidak perlu dibongkar lagi saat aplikasi akhirnya di-hosting. Nanti tinggal mengaktifkan fitur Webhook tambahan di dashboard Midtrans sebagai lapisan *backup*.

---

*Panduan ini dibuat sebagai referensi untuk tim developer selama masa pengembangan di environment lokal.*

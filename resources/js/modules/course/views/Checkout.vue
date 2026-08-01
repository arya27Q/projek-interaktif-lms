<template>
  <div class="w-full overflow-x-auto animate-fade-in [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] scrollbar-none">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:min-w-300 xl:min-w-300">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-on-surface mb-2">Checkout</h1>
        <p class="text-secondary font-body-md">Selesaikan pembayaran untuk mulai belajar.</p>
      </div>

      <div v-if="isLoading" class="flex justify-center py-20">
        <span class="material-symbols-outlined animate-spin text-4xl text-primary">progress_activity</span>
      </div>

      <div v-else-if="course" class="flex flex-col md:flex-row gap-8">
      <!-- Left Column: Course Info & Form -->
      <div class="flex-1 min-w-0 space-y-6">
        
        <!-- Course Card -->
        <div class="glass-card p-6 rounded-2xl border border-surface-container-low flex flex-col sm:flex-row gap-6">
          <div class="w-full sm:w-48 h-32 rounded-xl overflow-hidden shrink-0 bg-surface-container relative group">
            <img 
              :src="course.thumbnail_url || 'https://via.placeholder.com/600x400.png?text=Course'" 
              :alt="course.title"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            />
            <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>
          </div>
          <div class="flex flex-col justify-center min-w-0">
            <div class="flex flex-wrap items-center gap-2 mb-2">
              <span class="px-2.5 py-1 rounded-md bg-primary/10 text-primary font-label-sm font-semibold tracking-wide uppercase whitespace-nowrap">
                {{ course.category }}
              </span>
              <span class="flex items-center text-secondary text-sm whitespace-nowrap">
                <span class="material-symbols-outlined text-sm mr-1">signal_cellular_alt</span>
                {{ course.level }}
              </span>
            </div>
            <h2 class="text-xl font-bold text-on-surface mb-2 line-clamp-2">{{ course.title }}</h2>
            <div class="flex items-center text-secondary text-sm">
              <span class="material-symbols-outlined text-sm mr-1">person</span>
              <span>Instruktur: {{ course.instructor?.name }}</span>
            </div>
          </div>
        </div>

        <!-- Billing Info (Readonly for prototype) -->
        <div class="glass-card p-6 rounded-2xl border border-surface-container-low">
          <h3 class="text-lg font-bold text-on-surface mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">person_check</span>
            Informasi Pembeli
          </h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-secondary mb-1">Nama Lengkap</label>
              <input type="text" value="Budi Santoso" disabled class="w-full px-4 py-2 bg-surface-container-low border border-surface-container-high rounded-xl text-on-surface opacity-70 cursor-not-allowed">
            </div>
            <div>
              <label class="block text-sm font-medium text-secondary mb-1">Alamat Email</label>
              <input type="email" value="budi@example.com" disabled class="w-full px-4 py-2 bg-surface-container-low border border-surface-container-high rounded-xl text-on-surface opacity-70 cursor-not-allowed">
            </div>
          </div>
          <p class="text-xs text-secondary mt-3 flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">info</span>
            Data diambil dari profil Anda. Pastikan email aktif untuk pengiriman struk.
          </p>
        </div>

      </div>

      <!-- Right Column: Order Summary -->
      <div class="w-full md:w-80 lg:w-85 xl:w-100 shrink-0">
        <div class="glass-card p-6 rounded-2xl border border-surface-container-low sticky top-24 shadow-[0px_15px_40px_rgba(0,0,0,0.06)]">
          <h3 class="text-lg font-bold text-on-surface mb-6">Ringkasan Pesanan</h3>
          
          <div class="space-y-4 mb-6">
            <div class="flex justify-between items-center text-on-surface-variant">
              <span>Harga Kursus</span>
              <span class="font-medium">{{ course.price == 0 ? 'Gratis' : 'Rp ' + course.price.toLocaleString('id-ID') }}</span>
            </div>
          </div>

          <div class="border-t border-surface-container-high pt-4 mb-8">
            <div class="flex justify-between items-center">
              <span class="text-on-surface font-semibold">Total Bayar</span>
              <span class="text-2xl font-bold text-primary">{{ course.price == 0 ? 'Gratis' : 'Rp ' + course.price.toLocaleString('id-ID') }}</span>
            </div>
          </div>

          <!-- Checkout Button -->
          <button 
            @click="processPayment"
            :disabled="isProcessing"
            class="w-full py-4 rounded-xl font-bold tracking-wide transition-all duration-300 flex items-center justify-center gap-2 group relative overflow-hidden"
            :class="isProcessing ? 'bg-surface-container-high text-secondary cursor-not-allowed' : 'bg-primary text-on-primary hover:shadow-lg hover:shadow-primary/30 hover:-translate-y-1'"
          >
            <!-- Hover overlay -->
            <div v-if="!isProcessing" class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
            
            <span v-if="isProcessing" class="material-symbols-outlined animate-spin">refresh</span>
            <span v-else class="material-symbols-outlined">lock</span>
            
            {{ isProcessing ? 'Memproses...' : 'Bayar Sekarang (Midtrans)' }}
          </button>

          <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
             <!-- Simulated payment logos (Styled as badges) -->
             <div class="h-7 px-3 flex items-center bg-white rounded border border-surface-container shadow-sm grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all cursor-default">
               <span class="text-[#00A5CF] font-bold italic text-xs tracking-tighter">GoPay</span>
             </div>
             <div class="h-7 px-3 flex items-center bg-white rounded border border-surface-container shadow-sm grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all cursor-default">
               <span class="text-[#ED2C25] font-black italic text-xs tracking-tighter">QRIS</span>
             </div>
             <div class="h-7 px-3 flex items-center bg-white rounded border border-surface-container shadow-sm grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all cursor-default">
               <span class="text-[#005E6A] font-extrabold italic text-xs tracking-tighter">BCA</span>
             </div>
             <div class="h-7 px-3 flex items-center bg-white rounded border border-surface-container shadow-sm grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all cursor-default">
               <span class="text-[#1A1F71] font-bold italic text-xs">VISA</span>
             </div>
          </div>
          <p class="text-center text-xs text-secondary mt-4">
            Pembayaran dijamin aman (Secured by Midtrans).
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Payment Simulation Modal -->
    <Teleport to="body">
      <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
          <!-- Backdrop -->
          <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeModal"></div>
          
          <!-- Modal Content -->
          <div class="relative bg-surface-container-lowest w-full max-w-md rounded-3xl shadow-2xl overflow-hidden border border-surface-container-low flex flex-col">
            
            <!-- Midtrans Header Mock -->
            <div class="bg-surface-container-low px-6 py-4 border-b border-surface-container flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">security</span>
                <span class="font-bold text-on-surface tracking-wide">Midtrans Simulator</span>
              </div>
              <button @click="closeModal" class="text-secondary hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined">close</span>
              </button>
            </div>

            <div class="p-8 flex flex-col items-center text-center">
              <div class="w-20 h-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-4xl">contactless</span>
              </div>
              <h3 class="text-2xl font-bold text-on-surface mb-2">Simulasi Pembayaran</h3>
              <p class="text-secondary font-body-md mb-8">
                Total Tagihan: <span class="font-bold text-on-surface">Rp 403.200</span><br>
                Di produksi, tombol di bawah akan memanggil <code class="bg-surface-container px-1 py-0.5 rounded text-sm text-primary">window.snap.pay()</code>
              </p>
              
              <div class="w-full space-y-3">
                <button @click="confirmPayment" class="w-full bg-primary text-on-primary py-3.5 rounded-xl font-bold hover:shadow-lg hover:shadow-primary/30 hover:-translate-y-0.5 transition-all">
                  Simulasikan Bayar Sukses
                </button>
                <button @click="closeModal" class="w-full bg-surface-container-low text-on-surface py-3.5 rounded-xl font-bold hover:bg-surface-container transition-all">
                  Batalkan
                </button>
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import Swal from 'sweetalert2';

const route = useRoute();
const router = useRouter();
const isProcessing = ref(false);
const course = ref(null);
const isLoading = ref(true);

const fetchCourse = async () => {
  try {
    const res = await axios.get(`/courses/${route.params.id}`);
    course.value = res.data.data;
  } catch (error) {
    console.error(error);
    Swal.fire('Error', 'Gagal memuat kursus', 'error');
  } finally {
    isLoading.value = false;
  }
};

const loadSnapScript = () => {
  return new Promise((resolve) => {
    if (document.getElementById('midtrans-script')) {
      resolve();
      return;
    }
    const script = document.createElement('script');
    script.id = 'midtrans-script';
    // Gunakan URL Sandbox untuk testing
    script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
    
    // Ambil client key asli dari meta tag yang ada di welcome.blade.php
    const clientKey = document.querySelector('meta[name="midtrans-client-key"]')?.getAttribute('content');
    script.setAttribute('data-client-key', clientKey || 'SB-Mid-client-DUMMY'); 
    
    script.onload = () => resolve();
    document.head.appendChild(script);
  });
};

onMounted(async () => {
  await fetchCourse();
  await loadSnapScript();
});

const processPayment = async () => {
  isProcessing.value = true;
  try {
    const res = await axios.post(`/checkout/${course.value.id}/process`);
    
    if (res.data.is_free) {
      Swal.fire('Berhasil!', 'Kursus gratis berhasil ditambahkan.', 'success');
      router.push(`/course/${course.value.id}`);
      return;
    }

    const snapToken = res.data.snap_token;
    const orderId = res.data.order_id;

    // Panggil Snap Midtrans
    window.snap.pay(snapToken, {
      onSuccess: async function (result) {
        // Trik Localhost: Beritahu backend untuk memverifikasi karena Webhook tidak jalan di localhost
        await axios.post(`/checkout/${orderId}/verify`);
        
        Swal.fire('Pembayaran Berhasil!', 'Selamat belajar.', 'success');
        router.push(`/course/${course.value.id}`);
      },
      onPending: function (result) {
        Swal.fire('Menunggu Pembayaran', 'Silakan selesaikan pembayaran Anda.', 'info');
      },
      onError: function (result) {
        Swal.fire('Gagal', 'Pembayaran gagal diproses.', 'error');
      },
      onClose: function () {
        Swal.fire('Dibatalkan', 'Anda menutup jendela sebelum menyelesaikan pembayaran.', 'warning');
      }
    });

  } catch (error) {
    console.error(error);
    Swal.fire('Error', 'Terjadi kesalahan saat memproses pembayaran.', 'error');
  } finally {
    isProcessing.value = false;
  }
};
</script>

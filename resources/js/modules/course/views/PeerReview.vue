<template>
  <div class="max-w-5xl mx-auto pb-10">
    
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
      <button @click="$router.back()" class="w-10 h-10 rounded-full bg-surface-container-lowest border border-surface-container-low flex items-center justify-center text-secondary hover:text-primary transition-colors">
        <span class="material-symbols-outlined">arrow_back</span>
      </button>
      <div>
        <h1 class="text-2xl font-bold text-on-surface">Tugas Akhir: Redesain Aplikasi Mobile</h1>
        <p class="text-secondary text-sm mt-1 flex items-center gap-2">
          <span class="px-2 py-0.5 bg-primary/10 text-primary rounded font-bold text-[10px] uppercase">Modul 6</span>
          Batas Waktu: 30 Juli 2026
        </p>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      
      <!-- Kolom Utama: Instruksi & Pengumpulan -->
      <div class="lg:col-span-2 space-y-8">
        
        <!-- Instruksi -->
        <div class="bg-surface-container-lowest rounded-2xl border border-surface-container-low p-6 md:p-8">
          <h2 class="text-lg font-bold text-on-surface mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">description</span> Instruksi Tugas
          </h2>
          <div class="prose prose-sm text-secondary prose-p:leading-relaxed max-w-none">
            <p>Berdasarkan materi yang telah dipelajari pada Modul 1 hingga 5, buatlah rancangan ulang (redesign) antarmuka aplikasi mobile dari sebuah layanan publik (misal: aplikasi kereta api, listrik, atau air).</p>
            <ul>
              <li>Fokus pada perbaikan hierarki visual dan aksesibilitas.</li>
              <li>Terapkan sistem desain interaktif (hover, active, focus states).</li>
              <li>Kumpulkan dalam bentuk link prototipe Figma atau PDF presentasi (maks 10 halaman).</li>
            </ul>
          </div>
          
          <div class="mt-6 p-4 bg-tertiary/5 rounded-xl border border-tertiary/20 flex gap-4">
            <span class="material-symbols-outlined text-tertiary">info</span>
            <div class="text-sm">
              <p class="font-bold text-on-surface mb-1">Penilaian Silang (Cross-Review)</p>
              <p class="text-secondary">Tugas Anda akan dinilai oleh 2 siswa lain secara anonim (bobot 40%) dan Instruktur (bobot 60%). Anda juga wajib menilai 2 tugas milik siswa lain setelah mengumpulkan tugas ini.</p>
            </div>
          </div>
        </div>

        <!-- Form Pengumpulan -->
        <div class="bg-surface-container-lowest rounded-2xl border border-surface-container-low p-6 md:p-8 relative overflow-hidden">
          <div v-if="submissionStatus === 'submitted'" class="absolute inset-0 bg-surface-container-lowest z-10 flex flex-col items-center justify-center text-center p-8">
            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center text-primary mb-4">
              <span class="material-symbols-outlined text-[32px]">check_circle</span>
            </div>
            <h3 class="text-xl font-bold text-on-surface mb-2">Tugas Berhasil Dikumpulkan!</h3>
            <p class="text-secondary text-sm mb-6 max-w-sm">Anda telah mengumpulkan tugas. Langkah selanjutnya adalah menilai 2 tugas siswa lain untuk mendapatkan nilai akhir Anda.</p>
            <button @click="showReviewTab = true; submissionStatus = 'reviewing'" class="px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:shadow-lg transition-all active:scale-95 flex items-center gap-2">
              Mulai Penilaian Silang <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
          </div>

          <h2 class="text-lg font-bold text-on-surface mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">upload_file</span> Kumpulkan Tugas
          </h2>
          
          <div class="space-y-5">
            <div>
              <label class="block text-sm font-bold text-on-surface mb-2">Tautan Prototipe (Figma/Web)</label>
              <input type="url" class="w-full bg-surface-container-low border border-transparent focus:border-primary focus:bg-surface-container-lowest rounded-xl px-4 py-3 text-sm outline-none transition-all" placeholder="https://figma.com/file/..."/>
            </div>
            
            <div>
              <label class="block text-sm font-bold text-on-surface mb-2">Atau Unggah File (Opsional)</label>
              <div class="border-2 border-dashed border-outline-variant rounded-xl p-8 flex flex-col items-center justify-center text-center hover:bg-surface-container-low hover:border-primary cursor-pointer transition-all group">
                <div class="w-12 h-12 rounded-full bg-surface-container-high group-hover:bg-primary/10 flex items-center justify-center text-secondary group-hover:text-primary transition-colors mb-3">
                  <span class="material-symbols-outlined text-[24px]">cloud_upload</span>
                </div>
                <p class="text-sm font-bold text-on-surface">Pilih file atau tarik ke sini</p>
                <p class="text-xs text-secondary mt-1">PDF, ZIP, atau JPG (Maks 10MB)</p>
              </div>
            </div>
            
            <div>
              <label class="block text-sm font-bold text-on-surface mb-2">Catatan Tambahan (Opsional)</label>
              <textarea class="w-full bg-surface-container-low border border-transparent focus:border-primary focus:bg-surface-container-lowest rounded-xl px-4 py-3 text-sm outline-none transition-all resize-none" rows="3" placeholder="Jelaskan sedikit tentang pendekatan desain Anda..."></textarea>
            </div>
            
            <div class="pt-4 flex justify-end">
              <button @click="submitAssignment" class="px-8 py-3 bg-primary text-white rounded-xl font-bold hover:shadow-lg transition-all active:scale-95 flex items-center gap-2">
                Kirim Tugas <span class="material-symbols-outlined text-[18px]">send</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Interface Penilaian Silang (Muncul setelah mengumpulkan) -->
        <div v-if="showReviewTab" class="bg-surface-container-lowest rounded-2xl border border-surface-container-low p-6 md:p-8 animate-in slide-in-from-bottom-4">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-on-surface flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">groups</span> Penilaian Silang
            </h2>
            <div class="flex gap-2">
              <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[11px] font-bold">1 / 2 Dinilai</span>
            </div>
          </div>
          
          <div class="bg-surface-container-low rounded-xl p-5 mb-6">
            <div class="flex items-center justify-between mb-4">
              <span class="text-xs font-bold text-secondary uppercase">Tugas Anonim #4092</span>
              <a href="#" class="text-primary text-sm font-bold hover:underline flex items-center gap-1">
                Buka Tautan <span class="material-symbols-outlined text-[16px]">open_in_new</span>
              </a>
            </div>
            <p class="text-sm text-secondary italic mb-4">"Saya fokus merombak navigasi bawah karena di aplikasi aslinya sangat sulit dijangkau..."</p>
          </div>
          
          <div class="space-y-6">
            <div>
              <label class="text-sm font-bold text-on-surface mb-3 flex items-center justify-between">
                Hierarki Visual (0-10)
                <span class="text-primary text-lg">{{ score1 }}</span>
              </label>
              <input type="range" min="0" max="10" v-model="score1" class="w-full accent-primary">
            </div>
            <div>
              <label class="text-sm font-bold text-on-surface mb-3 flex items-center justify-between">
                Penerapan State Interaktif (0-10)
                <span class="text-primary text-lg">{{ score2 }}</span>
              </label>
              <input type="range" min="0" max="10" v-model="score2" class="w-full accent-primary">
            </div>
            <div>
              <label class="block text-sm font-bold text-on-surface mb-2">Komentar Konstruktif</label>
              <textarea class="w-full bg-surface-container-low border border-transparent focus:border-primary focus:bg-surface-container-lowest rounded-xl px-4 py-3 text-sm outline-none transition-all resize-none" rows="3" placeholder="Berikan saran untuk perbaikan desain ini..."></textarea>
            </div>
            
            <button @click="submitReview" class="w-full py-3 bg-on-surface text-surface-container-lowest rounded-xl font-bold hover:shadow-lg transition-all active:scale-95">
              Kirim Penilaian
            </button>
          </div>
        </div>

      </div>

      <!-- Kolom Kanan: Status & Rubrik -->
      <div class="space-y-6">
        
        <!-- Status Panel -->
        <div class="bg-surface-container-lowest rounded-2xl border border-surface-container-low p-6">
          <h3 class="font-bold text-on-surface mb-5 text-sm uppercase tracking-wider text-center">Status Anda</h3>
          
          <div class="space-y-5">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0"
                :class="submissionStatus === 'pending' ? 'bg-surface-container-high text-secondary' : 'bg-green-100 text-green-600'">
                <span class="material-symbols-outlined">{{ submissionStatus === 'pending' ? 'upload_file' : 'check' }}</span>
              </div>
              <div>
                <p class="text-sm font-bold text-on-surface">Pengumpulan</p>
                <p class="text-xs text-secondary">{{ submissionStatus === 'pending' ? 'Belum mengumpulkan' : 'Selesai' }}</p>
              </div>
            </div>
            
            <div class="w-0.5 h-6 bg-surface-container-high ml-5 -my-3"></div>
            
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0"
                :class="!showReviewTab ? 'bg-surface-container-high text-secondary' : 'bg-primary/10 text-primary'">
                <span class="material-symbols-outlined">groups</span>
              </div>
              <div>
                <p class="text-sm font-bold text-on-surface">Penilaian Silang</p>
                <p class="text-xs text-secondary">Menilai 2 tugas teman</p>
              </div>
            </div>
            
            <div class="w-0.5 h-6 bg-surface-container-high ml-5 -my-3"></div>
            
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full flex items-center justify-center bg-surface-container-high text-secondary shrink-0">
                <span class="material-symbols-outlined">school</span>
              </div>
              <div>
                <p class="text-sm font-bold text-on-surface">Penilaian Instruktur</p>
                <p class="text-xs text-secondary">Menunggu dinilai</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Rubrik -->
        <div class="bg-surface-container-lowest rounded-2xl border border-surface-container-low p-6">
          <h3 class="font-bold text-on-surface mb-4 text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-secondary">rule</span> Rubrik Penilaian
          </h3>
          <ul class="space-y-4">
            <li class="flex flex-col gap-1">
              <div class="flex justify-between items-center text-sm font-bold">
                <span>Hierarki Visual</span>
                <span class="text-primary bg-primary/10 px-2 py-0.5 rounded text-xs">40%</span>
              </div>
              <p class="text-xs text-secondary">Penggunaan kontras, ukuran tipografi, dan spasi secara efektif.</p>
            </li>
            <li class="flex flex-col gap-1">
              <div class="flex justify-between items-center text-sm font-bold">
                <span>Interaktivitas</span>
                <span class="text-primary bg-primary/10 px-2 py-0.5 rounded text-xs">40%</span>
              </div>
              <p class="text-xs text-secondary">Semua elemen interaktif (tombol, input) memiliki state yang jelas.</p>
            </li>
            <li class="flex flex-col gap-1">
              <div class="flex justify-between items-center text-sm font-bold">
                <span>Aksesibilitas</span>
                <span class="text-primary bg-primary/10 px-2 py-0.5 rounded text-xs">20%</span>
              </div>
              <p class="text-xs text-secondary">Kontras rasio warna yang memenuhi standar aksesibilitas minimum.</p>
            </li>
          </ul>
        </div>
        
      </div>
      
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const submissionStatus = ref('pending'); // pending, submitted, reviewing
const showReviewTab = ref(false);
const score1 = ref(5);
const score2 = ref(5);

const submitAssignment = () => {
  submissionStatus.value = 'submitted';
};

const submitReview = () => {
  alert('Penilaian berhasil dikirim. Terima kasih!');
};
</script>

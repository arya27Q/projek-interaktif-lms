<template>
  <div class="max-w-5xl mx-auto">

    <!-- Hero Section -->
    <div class="text-center mb-16">
      <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-sm font-semibold mb-6">
        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
        Tingkatkan Pengalamanmu
      </div>
      <h1 class="text-4xl lg:text-5xl font-extrabold text-on-surface mb-5 leading-tight">
        Belajar Lebih Cepat,<br />
        <span class="text-primary">Raih Lebih Banyak.</span>
      </h1>
      <p class="text-secondary text-lg max-w-xl mx-auto leading-relaxed">
        Akses tak terbatas ke semua kursus premium, sertifikat resmi, dan fitur eksklusif yang dirancang untuk mempercepat karirmu.
      </p>
    </div>

    <!-- Billing Toggle -->
    <div class="flex items-center justify-center gap-4 mb-12">
      <span :class="billing === 'monthly' ? 'text-on-surface font-bold' : 'text-secondary'" class="text-sm transition-colors">Bulanan</span>
      <button
        @click="billing = billing === 'monthly' ? 'yearly' : 'monthly'"
        class="relative w-14 h-7 rounded-full transition-colors duration-300"
        :class="billing === 'yearly' ? 'bg-primary' : 'bg-surface-container-high'"
      >
        <span
          class="absolute top-1 left-1 w-5 h-5 bg-white rounded-full shadow-md transition-transform duration-300"
          :class="billing === 'yearly' ? 'translate-x-7' : 'translate-x-0'"
        ></span>
      </button>
      <div class="flex items-center gap-2">
        <span :class="billing === 'yearly' ? 'text-on-surface font-bold' : 'text-secondary'" class="text-sm transition-colors">Tahunan</span>
        <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Hemat 40%</span>
      </div>
    </div>

    <!-- Pricing Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">

      <!-- Free Plan -->
      <div
        @click="selectedPlan = 'free'"
        class="rounded-2xl border-2 p-7 bg-surface-container-lowest flex flex-col cursor-pointer transition-all duration-200 hover:-translate-y-1"
        :class="selectedPlan === 'free'
          ? 'border-on-surface shadow-xl'
          : 'border-surface-container hover:border-secondary/40 hover:shadow-md'"
      >
        <div class="mb-6">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-secondary uppercase tracking-widest">Gratis</span>
            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all"
              :class="selectedPlan === 'free' ? 'border-on-surface bg-on-surface' : 'border-surface-container-high'">
              <span v-if="selectedPlan === 'free'" class="material-symbols-outlined text-white text-[12px]" style="font-variation-settings: 'FILL' 1;">check</span>
            </div>
          </div>
          <div class="mt-3 flex items-end gap-1">
            <span class="text-4xl font-extrabold text-on-surface">Rp 0</span>
          </div>
          <p class="text-secondary text-sm mt-2">Untuk pemula yang baru mulai.</p>
        </div>
        <ul class="space-y-3 flex-1 mb-8">
          <li v-for="f in freeFeatures" :key="f" class="flex items-start gap-2.5 text-sm text-secondary">
            <span class="material-symbols-outlined text-[18px] text-secondary/50 shrink-0 mt-0.5">check</span>
            {{ f }}
          </li>
        </ul>
        <button
          class="w-full py-3 rounded-xl border font-semibold text-sm transition-all"
          :class="selectedPlan === 'free'
            ? 'border-on-surface bg-on-surface text-white'
            : 'border-surface-container-high text-secondary hover:bg-surface-container-low'"
        >
          {{ selectedPlan === 'free' ? '✓ Dipilih' : 'Paket Saat Ini' }}
        </button>
      </div>

      <!-- Pro Plan (Featured) -->
      <div
        @click="selectedPlan = 'pro'"
        class="rounded-2xl border-2 p-7 bg-surface-container-lowest flex flex-col relative cursor-pointer transition-all duration-200 hover:-translate-y-1"
        :class="selectedPlan === 'pro'
          ? 'border-primary shadow-2xl shadow-primary/20 scale-[1.02]'
          : 'border-primary/60 shadow-xl shadow-primary/10 hover:shadow-2xl hover:border-primary'"
      >
        <!-- Badge Popular -->
        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2">
          <span class="bg-primary text-white text-[11px] font-bold px-4 py-1 rounded-full shadow-md whitespace-nowrap">✨ Paling Populer</span>
        </div>

        <div class="mb-6">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-primary uppercase tracking-widest">Pro</span>
            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all"
              :class="selectedPlan === 'pro' ? 'border-primary bg-primary' : 'border-primary/40'">
              <span v-if="selectedPlan === 'pro'" class="material-symbols-outlined text-white text-[12px]" style="font-variation-settings: 'FILL' 1;">check</span>
            </div>
          </div>
          <div class="mt-3 flex items-end gap-1">
            <span class="text-4xl font-extrabold text-on-surface">
              {{ billing === 'monthly' ? 'Rp 129.000' : 'Rp 77.400' }}
            </span>
            <span class="text-secondary text-sm mb-1">/bln</span>
          </div>
          <p class="text-secondary text-sm mt-2">
            {{ billing === 'yearly' ? 'Ditagih tahunan · Hemat Rp 621.600/tahun' : 'Ditagih setiap bulan, batalkan kapan saja.' }}
          </p>
        </div>
        <ul class="space-y-3 flex-1 mb-8">
          <li v-for="f in proFeatures" :key="f.text" class="flex items-start gap-2.5 text-sm">
            <span class="material-symbols-outlined text-[18px] text-primary shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <span :class="f.highlight ? 'text-on-surface font-semibold' : 'text-secondary'">{{ f.text }}</span>
          </li>
        </ul>
        <button class="w-full py-3.5 rounded-xl bg-primary text-white font-bold text-sm hover:bg-on-surface transition-all active:scale-95 shadow-md hover:shadow-lg">
          {{ selectedPlan === 'pro' ? '✓ Dipilih · Mulai Uji Coba Gratis' : 'Mulai Uji Coba 7 Hari Gratis' }}
        </button>
        <p class="text-center text-[11px] text-secondary/70 mt-3">Tidak perlu kartu kredit</p>
      </div>

      <!-- Team Plan -->
      <div
        @click="selectedPlan = 'team'"
        class="rounded-2xl border-2 p-7 bg-surface-container-lowest flex flex-col cursor-pointer transition-all duration-200 hover:-translate-y-1"
        :class="selectedPlan === 'team'
          ? 'border-tertiary shadow-xl shadow-tertiary/10'
          : 'border-surface-container hover:border-tertiary/40 hover:shadow-md'"
      >
        <div class="mb-6">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-secondary uppercase tracking-widest">Tim</span>
            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all"
              :class="selectedPlan === 'team' ? 'border-tertiary bg-tertiary' : 'border-surface-container-high'">
              <span v-if="selectedPlan === 'team'" class="material-symbols-outlined text-white text-[12px]" style="font-variation-settings: 'FILL' 1;">check</span>
            </div>
          </div>
          <div class="mt-3 flex items-end gap-1">
            <span class="text-4xl font-extrabold text-on-surface">
              {{ billing === 'monthly' ? 'Rp 249.000' : 'Rp 149.400' }}
            </span>
            <span class="text-secondary text-sm mb-1">/org/bln</span>
          </div>
          <p class="text-secondary text-sm mt-2">Untuk tim dan perusahaan, min. 5 orang.</p>
        </div>
        <ul class="space-y-3 flex-1 mb-8">
          <li v-for="f in teamFeatures" :key="f" class="flex items-start gap-2.5 text-sm text-secondary">
            <span class="material-symbols-outlined text-[18px] text-tertiary shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            {{ f }}
          </li>
        </ul>
        <button
          class="w-full py-3 rounded-xl border font-semibold text-sm transition-all"
          :class="selectedPlan === 'team'
            ? 'border-tertiary bg-tertiary text-white'
            : 'border-primary text-primary hover:bg-primary hover:text-white'"
        >
          {{ selectedPlan === 'team' ? '✓ Dipilih' : 'Hubungi Tim Kami' }}
        </button>
      </div>

    </div>

    <!-- Feature Comparison -->
    <div class="mb-16">
      <h2 class="text-center text-xl font-bold text-on-surface mb-8">Perbandingan Fitur Lengkap</h2>
      <div class="rounded-2xl border border-surface-container overflow-hidden">
        <table class="w-full text-sm">
          <thead>
            <tr class="bg-surface-container-low border-b border-surface-container">
              <th class="text-left px-6 py-4 font-semibold text-secondary">Fitur</th>
              <th class="px-6 py-4 font-semibold text-secondary text-center">Gratis</th>
              <th class="px-6 py-4 font-bold text-primary text-center">Pro</th>
              <th class="px-6 py-4 font-semibold text-secondary text-center">Tim</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, i) in comparisonRows" :key="i"
              class="border-b border-surface-container last:border-0 hover:bg-surface-container-lowest/50 transition-colors">
              <td class="px-6 py-4 text-on-surface font-medium">{{ row.feature }}</td>
              <td class="px-6 py-4 text-center">
                <span v-if="row.free === true" class="material-symbols-outlined text-[18px] text-green-500" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <span v-else-if="row.free === false" class="material-symbols-outlined text-[18px] text-secondary/30">remove</span>
                <span v-else class="text-secondary text-xs">{{ row.free }}</span>
              </td>
              <td class="px-6 py-4 text-center bg-primary/5">
                <span v-if="row.pro === true" class="material-symbols-outlined text-[18px] text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <span v-else-if="row.pro === false" class="material-symbols-outlined text-[18px] text-secondary/30">remove</span>
                <span v-else class="text-primary font-semibold text-xs">{{ row.pro }}</span>
              </td>
              <td class="px-6 py-4 text-center">
                <span v-if="row.team === true" class="material-symbols-outlined text-[18px] text-green-500" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <span v-else-if="row.team === false" class="material-symbols-outlined text-[18px] text-secondary/30">remove</span>
                <span v-else class="text-secondary text-xs">{{ row.team }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Testimonials -->
    <div class="mb-16">
      <h2 class="text-center text-xl font-bold text-on-surface mb-8">Apa Kata Pengguna Pro</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div v-for="t in testimonials" :key="t.name"
          class="bg-surface-container-lowest border border-surface-container rounded-2xl p-6">
          <div class="flex gap-0.5 mb-4">
            <span v-for="n in 5" :key="n" class="material-symbols-outlined text-[16px] text-amber-400" style="font-variation-settings: 'FILL' 1;">star</span>
          </div>
          <p class="text-secondary text-sm leading-relaxed mb-5">"{{ t.quote }}"</p>
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center font-bold text-primary text-sm shrink-0">
              {{ t.name[0] }}
            </div>
            <div>
              <p class="font-semibold text-on-surface text-sm">{{ t.name }}</p>
              <p class="text-secondary text-xs">{{ t.role }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- FAQ -->
    <div class="mb-16">
      <h2 class="text-center text-xl font-bold text-on-surface mb-8">Pertanyaan Umum</h2>
      <div class="space-y-3 max-w-2xl mx-auto">
        <div v-for="(faq, i) in faqs" :key="i"
          class="bg-surface-container-lowest border border-surface-container rounded-2xl overflow-hidden">
          <button
            @click="openFaq = openFaq === i ? null : i"
            class="w-full text-left px-6 py-4 flex items-center justify-between gap-4 hover:bg-surface-container-low/50 transition-colors"
          >
            <span class="font-semibold text-on-surface text-sm">{{ faq.q }}</span>
            <span class="material-symbols-outlined text-secondary shrink-0 transition-transform duration-200" :class="openFaq === i ? 'rotate-180' : ''">expand_more</span>
          </button>
          <div v-show="openFaq === i" class="px-6 pb-5">
            <p class="text-secondary text-sm leading-relaxed">{{ faq.a }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Final CTA -->
    <div class="bg-primary rounded-3xl p-10 text-center text-white">
      <h2 class="text-2xl font-extrabold mb-3">Siap Mulai? Coba 7 Hari Gratis.</h2>
      <p class="text-white/70 mb-8 max-w-md mx-auto text-sm">Tidak ada risiko, tidak perlu kartu kredit. Batalkan kapan saja kalau tidak cocok.</p>
      <button class="bg-white text-primary font-bold px-8 py-3.5 rounded-xl hover:shadow-xl hover:-translate-y-0.5 transition-all active:scale-95">
        Mulai Uji Coba Gratis Sekarang
      </button>
    </div>

  </div>
</template>

<script setup>
import { ref } from 'vue';

const billing = ref('monthly');
const openFaq = ref(null);

const freeFeatures = [
  '5 kursus gratis pilihan',
  'Akses materi dasar',
  'Forum diskusi komunitas',
  'Sertifikat penyelesaian dasar',
];

const proFeatures = [
  { text: 'Akses tak terbatas ke 500+ kursus', highlight: true },
  { text: 'Sertifikat resmi berverifikasi', highlight: true },
  { text: 'Unduh materi untuk belajar offline', highlight: false },
  { text: 'Akses kuis & latihan soal premium', highlight: false },
  { text: 'Prioritas jawaban dari instruktur', highlight: false },
  { text: 'Fitur streak & leaderboard eksklusif', highlight: false },
  { text: 'Tanpa iklan, belajar fokus', highlight: false },
];

const teamFeatures = [
  'Semua fitur Pro',
  'Dashboard manajemen tim',
  'Laporan progres anggota',
  'Kursus kustom untuk tim',
  'Dukungan pelanggan prioritas',
  'Invoice & penagihan terpusat',
];

const comparisonRows = [
  { feature: 'Jumlah kursus', free: '5 kursus', pro: 'Tak terbatas', team: 'Tak terbatas' },
  { feature: 'Sertifikat resmi', free: false, pro: true, team: true },
  { feature: 'Unduh offline', free: false, pro: true, team: true },
  { feature: 'Kuis & latihan premium', free: false, pro: true, team: true },
  { feature: 'Forum diskusi', free: true, pro: true, team: true },
  { feature: 'Prioritas jawaban instruktur', free: false, pro: true, team: true },
  { feature: 'Leaderboard & badge eksklusif', free: false, pro: true, team: true },
  { feature: 'Tanpa iklan', free: false, pro: true, team: true },
  { feature: 'Dashboard manajemen tim', free: false, pro: false, team: true },
  { feature: 'Laporan progres tim', free: false, pro: false, team: true },
  { feature: 'Kursus kustom internal', free: false, pro: false, team: true },
  { feature: 'Dukungan prioritas 24/7', free: false, pro: false, team: true },
];

const testimonials = [
  {
    name: 'Arya Pratama',
    role: 'Frontend Developer · Jakarta',
    quote: 'Setelah upgrade ke Pro, saya bisa akses semua kursus React dan Node.js sekaligus. Dalam 3 bulan langsung dapat kerja di startup unicorn.',
  },
  {
    name: 'Sinta Rahayu',
    role: 'UI/UX Designer · Bandung',
    quote: 'Sertifikat dari NexLearn Pro benar-benar diakui HRD. Portofolio saya jadi jauh lebih kuat dibanding sebelumnya.',
  },
  {
    name: 'Bagas Wibowo',
    role: 'Data Analyst · Surabaya',
    quote: 'Fitur unduh offline sangat membantu waktu perjalanan. Belajar jadi konsisten dan streaknya terus jalan!',
  },
];

const faqs = [
  {
    q: 'Apakah ada uji coba gratis?',
    a: 'Ya! Kamu bisa mencoba NexLearn Pro selama 7 hari penuh tanpa biaya dan tanpa perlu kartu kredit. Jika tidak cocok, tidak ada yang ditagih.',
  },
  {
    q: 'Bisakah saya membatalkan kapan saja?',
    a: 'Tentu. Kamu bisa membatalkan langganan kapan saja melalui halaman pengaturan akun. Tidak ada biaya penalti atau pertanyaan.',
  },
  {
    q: 'Apa perbedaan paket bulanan dan tahunan?',
    a: 'Paket tahunan lebih hemat 40% dibandingkan bulanan. Kamu membayar sekaligus untuk 12 bulan dan mendapat akses penuh selama periode tersebut.',
  },
  {
    q: 'Apakah sertifikat Pro diakui oleh perusahaan?',
    a: 'Sertifikat NexLearn Pro dilengkapi dengan ID verifikasi unik yang bisa dicek langsung oleh rekruter. Sudah diakui oleh 200+ perusahaan teknologi di Indonesia.',
  },
  {
    q: 'Bagaimana cara kerja paket Tim?',
    a: 'Kamu bisa mendaftarkan tim minimal 5 orang dengan satu akun penagihan terpusat. Admin tim bisa memantau progres semua anggota dari satu dashboard.',
  },
];
</script>

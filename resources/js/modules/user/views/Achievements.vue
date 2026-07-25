<template>
  <div>
    <!-- Header -->
    <header class="mb-10 flex items-center gap-3">
      <router-link to="/profile" class="p-2 hover:bg-surface-container rounded-full transition-colors">
        <span class="material-symbols-outlined text-secondary">arrow_back</span>
      </router-link>
      <div>
        <h1 class="text-2xl font-bold text-on-surface">Pencapaian</h1>
        <p class="text-secondary text-sm mt-0.5">{{ unlockedCount }} dari {{ badges.length }} lencana diraih</p>
      </div>
    </header>

    <!-- Progress summary -->
    <div class="mb-10 p-5 bg-surface-container-lowest rounded-2xl border border-surface-container-low shadow-sm flex items-center gap-5">
      <div class="w-14 h-14 rounded-full border-4 border-primary/20 flex items-center justify-center shrink-0 relative">
        <span class="font-bold text-primary text-sm">{{ Math.round((unlockedCount / badges.length) * 100) }}%</span>
        <svg class="absolute inset-0 -rotate-90" viewBox="0 0 56 56">
          <circle cx="28" cy="28" r="24" fill="none" stroke="currentColor" stroke-width="4" class="text-surface-container-low"/>
          <circle cx="28" cy="28" r="24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"
            class="text-primary"
            :stroke-dasharray="`${2 * Math.PI * 24}`"
            :stroke-dashoffset="`${2 * Math.PI * 24 * (1 - unlockedCount / badges.length)}`"
            style="transition: stroke-dashoffset 1s ease"
          />
        </svg>
      </div>
      <div>
        <p class="font-semibold text-on-surface text-sm">Koleksi lencana kamu berkembang!</p>
        <p class="text-secondary text-sm mt-0.5">Masih ada <span class="font-semibold text-on-surface">{{ badges.length - unlockedCount }} lencana</span> lagi yang bisa kamu raih.</p>
      </div>
    </div>

    <!-- Certificates -->
    <section class="mb-10">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xs font-semibold text-secondary uppercase tracking-widest">Sertifikat Kelulusan</h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Certificate Card -->
        <router-link to="/certificate/1" class="group flex gap-4 p-5 rounded-2xl border border-surface-container bg-surface-container-lowest transition-all hover:border-primary hover:shadow-lg">
          <div class="w-16 h-16 rounded-xl bg-primary/10 text-primary flex flex-col items-center justify-center shrink-0 border border-primary/20 group-hover:scale-105 transition-transform">
            <span class="material-symbols-outlined text-[24px]">workspace_premium</span>
            <span class="text-[9px] font-bold mt-0.5 tracking-wider uppercase">Pro</span>
          </div>
          <div class="flex flex-col justify-center">
            <h3 class="font-bold text-on-surface text-sm group-hover:text-primary transition-colors">Mastering Advanced CSS Layouts</h3>
            <p class="text-xs text-secondary mt-1">Diterbitkan: 25 Juli 2026</p>
            <span class="text-primary text-xs font-bold mt-2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity -translate-x-2 group-hover:translate-x-0">
              Lihat Sertifikat <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </span>
          </div>
        </router-link>
      </div>
    </section>

    <!-- Unlocked badges -->
    <section class="mb-10">
      <h2 class="text-xs font-semibold text-secondary uppercase tracking-widest mb-4">Sudah Diraih</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <div
          v-for="badge in unlockedBadges"
          :key="badge.name"
          class="relative flex flex-col items-center text-center p-5 rounded-2xl border border-surface-container bg-surface-container-lowest transition-all duration-200 hover:shadow-md hover:-translate-y-1 cursor-default group"
        >
          <!-- Icon -->
          <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-3 bg-surface-container-low shadow-sm group-hover:scale-110 transition-transform duration-300">
            <img :src="badge.image" :alt="badge.name" class="w-10 h-10 object-contain drop-shadow-sm" />
          </div>

          <span class="font-semibold text-sm leading-tight mb-1 text-on-surface">{{ badge.name }}</span>
          <span class="text-[11px] text-secondary leading-snug">{{ badge.desc }}</span>

          <!-- Tiny earned timestamp -->
          <span class="mt-3 text-[10px] text-secondary/70 font-medium">{{ badge.earnedAt }}</span>
        </div>
      </div>
    </section>

    <!-- Locked badges -->
    <section>
      <h2 class="text-xs font-semibold text-secondary uppercase tracking-widest mb-4">Tantangan Tersisa</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <div
          v-for="badge in lockedBadges"
          :key="badge.name"
          class="flex flex-col items-center text-center p-5 rounded-2xl border border-surface-container-low bg-surface/50 opacity-60"
        >
          <div class="w-16 h-16 rounded-2xl bg-surface-container-low flex items-center justify-center mb-3 relative grayscale opacity-50">
            <img :src="badge.image" :alt="badge.name" class="w-10 h-10 object-contain" />
            <div class="absolute inset-0 flex items-center justify-center bg-surface-container-lowest/30 rounded-2xl">
              <span class="material-symbols-outlined text-[18px] text-secondary/80 drop-shadow-md">lock</span>
            </div>
          </div>
          <span class="font-semibold text-sm text-secondary/70 leading-tight mb-1">{{ badge.name }}</span>
          <span class="text-[11px] text-secondary/50 leading-snug">{{ badge.desc }}</span>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const badges = ref([
  {
    name: 'Pelajar Malam',
    desc: 'Belajar di atas jam 12 malam',
    image: 'https://fonts.gstatic.com/s/e/notoemoji/latest/1f989/512.webp',
    earnedAt: '3 hari lalu',
    unlocked: true,
  },
  {
    name: 'Pelajar Cepat',
    desc: 'Selesaikan 1 kursus dalam sehari',
    image: 'https://fonts.gstatic.com/s/e/notoemoji/latest/26a1/512.webp',
    earnedAt: '1 minggu lalu',
    unlocked: true,
  },
  {
    name: 'Streak 7 Hari',
    desc: 'Belajar 7 hari berturut-turut',
    image: 'https://fonts.gstatic.com/s/e/notoemoji/latest/1f525/512.webp',
    earnedAt: '5 hari lalu',
    unlocked: true,
  },
  {
    name: 'Maestro Kode',
    desc: 'Selesaikan jalur React',
    image: 'https://fonts.gstatic.com/s/e/notoemoji/latest/1f4bb/512.webp',
    earnedAt: 'Minggu ini',
    unlocked: true,
  },
  {
    name: 'Kupu-Kupu Sosial',
    desc: 'Komentar di 10 diskusi',
    image: 'https://fonts.gstatic.com/s/e/notoemoji/latest/1f98b/512.webp',
    earnedAt: '2 minggu lalu',
    unlocked: true,
  },
  { name: 'Burung Pagi', desc: 'Belajar jam 5 pagi', image: 'https://fonts.gstatic.com/s/e/notoemoji/latest/1f304/512.webp', unlocked: false },
  { name: 'Nilai Sempurna', desc: 'Nilai 100 di kuis akhir', image: 'https://fonts.gstatic.com/s/e/notoemoji/latest/1f4af/512.webp', unlocked: false },
  { name: 'Penolong', desc: 'Bantu jawab pertanyaan siswa lain', image: 'https://fonts.gstatic.com/s/e/notoemoji/latest/1f91d/512.webp', unlocked: false },
  { name: 'Streak 30 Hari', desc: 'Belajar 30 hari berturut-turut', image: 'https://fonts.gstatic.com/s/e/notoemoji/latest/1f525/512.webp', unlocked: false },
  { name: 'Lulus Cumlaude', desc: 'Selesaikan semua kursus wajib', image: 'https://fonts.gstatic.com/s/e/notoemoji/latest/1f393/512.webp', unlocked: false },
]);

const unlockedBadges = computed(() => badges.value.filter(b => b.unlocked));
const lockedBadges = computed(() => badges.value.filter(b => !b.unlocked));
const unlockedCount = computed(() => unlockedBadges.value.length);
</script>

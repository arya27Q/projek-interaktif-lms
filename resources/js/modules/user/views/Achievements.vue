<template>
  <div>
    <header class="mb-8 flex items-center gap-4">
      <router-link to="/profile" class="p-2 hover:bg-surface-container rounded-full transition-colors flex items-center justify-center">
        <span class="material-symbols-outlined text-on-surface">arrow_back</span>
      </router-link>
      <div>
        <h1 class="font-headline-md text-headline-md text-on-surface">Galeri Pencapaian</h1>
        <p class="text-on-surface-variant font-body-md text-body-md">Koleksi semua lencana yang Anda peroleh</p>
      </div>
    </header>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
      <div v-for="(badge, index) in badges" :key="index" class="flex flex-col items-center p-6 border border-surface-container rounded-2xl bg-surface hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
        <div class="rounded-full flex items-center justify-center mb-4 shrink-0" style="width: 80px; height: 80px;" :class="badge.unlocked ? badge.bgColor : 'bg-surface-container-high opacity-50'">
          <span :class="`material-symbols-outlined text-4xl ${badge.unlocked ? badge.iconColor : 'text-secondary'}`">{{ badge.icon }}</span>
        </div>
        <span :class="`font-label-sm text-label-sm text-center mb-2 ${badge.unlocked ? 'text-on-surface' : 'text-on-surface-variant'}`">{{ badge.name }}</span>
        <span class="text-xs text-center text-on-surface-variant">{{ badge.desc }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const badges = ref([
  { name: 'Night Owl', desc: 'Belajar di atas jam 12 malam', icon: 'dark_mode', bgColor: 'bg-primary-container/20', iconColor: 'text-primary', unlocked: true },
  { name: 'Fast Learner', desc: 'Selesai 1 course dalam 1 hari', icon: 'bolt', bgColor: 'bg-tertiary-container/20', iconColor: 'text-tertiary', unlocked: true },
  { name: '7 Day Streak', desc: 'Login 7 hari berturut-turut', icon: 'local_fire_department', bgColor: 'bg-error-container/20', iconColor: 'text-error', unlocked: true },
  { name: 'Master of React', desc: 'Selesaikan track React', icon: 'code', bgColor: 'bg-primary-container/20', iconColor: 'text-primary', unlocked: true },
  { name: 'Social Butterfly', desc: 'Komentar di 10 diskusi', icon: 'forum', bgColor: 'bg-secondary-container/50', iconColor: 'text-secondary', unlocked: true },
  { name: 'Early Bird', desc: 'Belajar jam 5 pagi', icon: 'wb_sunny', bgColor: '', iconColor: '', unlocked: false },
  { name: 'Perfect Score', desc: 'Nilai 100 di kuis akhir', icon: 'military_tech', bgColor: '', iconColor: '', unlocked: false },
  { name: 'Helper', desc: 'Bantu jawab pertanyaan siswa lain', icon: 'volunteer_activism', bgColor: '', iconColor: '', unlocked: false },
  { name: '30 Day Streak', desc: 'Login 30 hari berturut-turut', icon: 'whatshot', bgColor: '', iconColor: '', unlocked: false },
  { name: 'Graduated', desc: 'Selesaikan semua course wajib', icon: 'school', bgColor: '', iconColor: '', unlocked: false },
]);
</script>

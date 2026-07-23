<template>
  <div>
    <header class="mb-8 flex items-center gap-4">
      <router-link to="/profile" class="p-2 hover:bg-surface-container rounded-full transition-colors flex items-center justify-center">
        <span class="material-symbols-outlined text-on-surface">arrow_back</span>
      </router-link>
      <div>
        <h1 class="font-headline-md text-headline-md text-on-surface">Privasi Data</h1>
        <p class="text-on-surface-variant font-body-md text-body-md">Kelola visibilitas profil dan unduh data Anda</p>
      </div>
    </header>

    <div class="bg-surface rounded-3xl p-6 md:p-8 shadow-[0px_20px_40px_rgba(0,0,0,0.08)] max-w-2xl">
      
      <!-- Visibility Setting -->
      <section class="mb-10">
        <h2 class="font-label-sm text-label-sm text-on-surface-variant mb-4 uppercase tracking-wider">Visibilitas Profil</h2>
        <div class="flex flex-col gap-3">
          <label class="flex items-start gap-4 p-4 border border-surface-container rounded-xl cursor-pointer hover:bg-surface-container-lowest transition-colors" :class="{'border-primary bg-primary-container/5': visibility === 'public'}">
            <input type="radio" v-model="visibility" value="public" class="mt-1 text-primary focus:ring-primary"/>
            <div>
              <div class="font-body-md text-on-surface font-medium flex items-center gap-2">
                Publik <span class="material-symbols-outlined text-sm text-primary">public</span>
              </div>
              <div class="text-sm text-on-surface-variant">Profil, statistik belajar, dan pencapaian Anda dapat dilihat oleh siswa lain di papan peringkat.</div>
            </div>
          </label>
          
          <label class="flex items-start gap-4 p-4 border border-surface-container rounded-xl cursor-pointer hover:bg-surface-container-lowest transition-colors" :class="{'border-primary bg-primary-container/5': visibility === 'private'}">
            <input type="radio" v-model="visibility" value="private" class="mt-1 text-primary focus:ring-primary"/>
            <div>
              <div class="font-body-md text-on-surface font-medium flex items-center gap-2">
                Privat <span class="material-symbols-outlined text-sm text-secondary">lock</span>
              </div>
              <div class="text-sm text-on-surface-variant">Hanya instruktur dan admin yang dapat melihat progres belajar Anda.</div>
            </div>
          </label>
        </div>
      </section>

      <!-- Data Download -->
      <section class="mb-8">
        <h2 class="font-label-sm text-label-sm text-on-surface-variant mb-4 uppercase tracking-wider">Unduh Data Saya</h2>
        <p class="text-on-surface-variant text-body-md mb-4">
          Dapatkan salinan data pribadi Anda, termasuk riwayat kursus, sertifikat, dan pengaturan akun. Proses ini mungkin memakan waktu beberapa menit.
        </p>
        <button class="flex items-center gap-2 px-4 py-3 bg-surface-container-high text-on-surface font-label-sm text-label-sm rounded-xl hover:bg-surface-container-highest transition-all shadow-sm border border-surface-container">
          <span class="material-symbols-outlined">download</span>
          Minta Arsip Data
        </button>
      </section>

      <div class="flex justify-end pt-6 border-t border-surface-container">
        <button @click="saveSettings" class="px-6 py-3 bg-primary text-on-primary font-label-sm text-label-sm rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200">
          Simpan Pengaturan
        </button>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const visibility = ref('public');

const saveSettings = () => {
  console.log('Saved privacy settings:', visibility.value);
  router.push('/profile');
};
</script>

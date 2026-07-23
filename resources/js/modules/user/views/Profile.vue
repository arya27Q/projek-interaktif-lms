<template>
  <div>
    <!-- Profile Header -->
    <header class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-12">
      <div class="flex items-center gap-6">
        <div class="relative">
          <img alt="Alex Johnson" class="w-24 h-24 md:w-32 md:h-32 rounded-full object-cover shadow-[0px_20px_40px_rgba(0,0,0,0.08)] border-4 border-surface" src="https://lh3.googleusercontent.com/aida-public/AB6AXuARvtnGkjYWdlvqWvjWweBnY5qWJEu4rr1rOhpojtH3Uml4tCUTlpw7Hw0XMGFXYZ2IYO0I2gqSTGGLEmSv27D6RB4rh0Fg7exqkZ9xNjVIHJg1GIAGy1qwV_bWgQYdW1TsdydXHDxScxYbkWDnTgtQXMan7_VJ1r4L7j39wV09jhh8tjaK3aDVYBcMkqysyPHax4h9olbX-M8HNUc8RAjH2UQYIUZRjVVrNCKCB7LChF3l985UyXlZLBqxMbQH12aSiLARdFpl4E9y"/>
          <router-link to="/profile/edit" class="absolute bottom-0 right-0 p-2 bg-surface rounded-full shadow-md hover:bg-surface-container transition-colors flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-sm">edit</span>
          </router-link>
        </div>
        <div>
          <h1 class="font-display-lg-mobile text-display-lg-mobile lg:font-display-lg lg:text-display-lg text-on-surface mb-2">Alex Johnson</h1>
          <p class="text-on-surface-variant font-body-lg text-body-lg">Mahasiswa Ilmu Komputer • Angkatan 2024</p>
        </div>
      </div>
      <router-link to="/profile/edit" class="px-6 py-3 bg-primary text-on-primary rounded-xl font-label-sm text-label-sm hover:-translate-y-0.5 hover:shadow-[0px_10px_30px_rgba(0,88,190,0.3)] transition-all duration-200">
        Edit Profil
      </router-link>
    </header>
    
    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- 1. Personal Info Card -->
      <section class="md:col-span-1 bg-surface rounded-[20px] p-6 shadow-[0px_20px_40px_rgba(0,0,0,0.08)]">
        <h2 class="font-headline-md text-headline-md text-on-surface mb-6 border-b border-surface-container pb-4">Info Pribadi</h2>
        <div class="space-y-4">
          <div>
            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Email</label>
            <p class="font-body-md text-body-md text-on-surface">alex.johnson@student.edu</p>
          </div>
          <div>
            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Bio</label>
            <p class="font-body-md text-body-md text-on-surface">Sangat tertarik dengan AI dan Machine Learning. Sedang membangun proyek akhir yang keren!</p>
          </div>
          <div class="pt-4">
            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-3">Tautan Sosial</label>
            <div class="flex gap-3">
              <a class="p-2 bg-surface-container rounded-lg text-secondary hover:text-primary hover:bg-primary-container/10 transition-colors" href="#">
                <span class="material-symbols-outlined">link</span>
              </a>
              <a class="p-2 bg-surface-container rounded-lg text-secondary hover:text-primary hover:bg-primary-container/10 transition-colors" href="#">
                <span class="material-symbols-outlined">public</span>
              </a>
            </div>
          </div>
        </div>
      </section>
      
      <!-- 2. Achievement & 3. Stats (Spanning 2 columns) -->
      <div class="md:col-span-2 flex flex-col gap-6">
        <!-- Learning Stats -->
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="bg-surface rounded-[20px] p-6 shadow-[0px_20px_40px_rgba(0,0,0,0.08)] flex flex-col items-center justify-center text-center">
            <span class="material-symbols-outlined text-4xl text-primary mb-2" style="font-variation-settings: 'FILL' 1;">star</span>
            <div class="font-display-lg-mobile text-display-lg-mobile text-on-surface">12.5k</div>
            <div class="font-label-sm text-label-sm text-on-surface-variant mt-1">Total EXP</div>
          </div>
          <div class="bg-surface rounded-[20px] p-6 shadow-[0px_20px_40px_rgba(0,0,0,0.08)] flex flex-col items-center justify-center text-center">
            <span class="material-symbols-outlined text-4xl text-primary mb-2" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <div class="font-display-lg-mobile text-display-lg-mobile text-on-surface">14</div>
            <div class="font-label-sm text-label-sm text-on-surface-variant mt-1">Kursus Selesai</div>
          </div>
          <div class="bg-surface rounded-[20px] p-6 shadow-[0px_20px_40px_rgba(0,0,0,0.08)] flex flex-col items-center justify-center text-center">
            <span class="material-symbols-outlined text-4xl text-primary mb-2" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
            <div class="font-display-lg-mobile text-display-lg-mobile text-on-surface">8</div>
            <div class="font-label-sm text-label-sm text-on-surface-variant mt-1">Sertifikat</div>
          </div>
        </section>
        
        <!-- Achievement Gallery -->
        <section class="bg-surface rounded-[20px] p-6 shadow-[0px_20px_40px_rgba(0,0,0,0.08)] flex-grow">
          <div class="flex justify-between items-center mb-6">
            <h2 class="font-headline-md text-headline-md text-on-surface">Galeri Pencapaian</h2>
            <router-link to="/profile/achievements" class="text-primary font-label-sm text-label-sm hover:underline">Lihat Semua</router-link>
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="flex flex-col items-center p-4 border border-surface-container rounded-xl hover:shadow-md transition-shadow">
              <div class="rounded-full bg-primary-container/20 flex items-center justify-center mb-3 shrink-0" style="width: 64px; height: 64px;">
                <span class="material-symbols-outlined text-primary text-3xl">dark_mode</span>
              </div>
              <span class="font-label-sm text-label-sm text-center">Night Owl</span>
            </div>
            <div class="flex flex-col items-center p-4 border border-surface-container rounded-xl hover:shadow-md transition-shadow">
              <div class="rounded-full bg-tertiary-container/20 flex items-center justify-center mb-3 shrink-0" style="width: 64px; height: 64px;">
                <span class="material-symbols-outlined text-tertiary text-3xl">bolt</span>
              </div>
              <span class="font-label-sm text-label-sm text-center">Fast Learner</span>
            </div>
            <div class="flex flex-col items-center p-4 border border-surface-container rounded-xl hover:shadow-md transition-shadow">
              <div class="rounded-full bg-error-container/20 flex items-center justify-center mb-3 shrink-0" style="width: 64px; height: 64px;">
                <span class="material-symbols-outlined text-error text-3xl">local_fire_department</span>
              </div>
              <span class="font-label-sm text-label-sm text-center">7 Day Streak</span>
            </div>
            <div class="flex flex-col items-center p-4 border border-surface-container rounded-xl hover:shadow-md transition-shadow">
              <div class="rounded-full bg-surface-container-high flex items-center justify-center mb-3 opacity-50 shrink-0" style="width: 64px; height: 64px;">
                <span class="material-symbols-outlined text-secondary text-3xl">lock</span>
              </div>
              <span class="font-label-sm text-label-sm text-center text-on-surface-variant">Terkunci</span>
            </div>
          </div>
        </section>
      </div>
      
      <!-- 4. Privacy & Account Settings -->
      <section class="md:col-span-3 bg-surface rounded-[20px] p-6 shadow-[0px_20px_40px_rgba(0,0,0,0.08)] mt-6">
        <h2 class="font-headline-md text-headline-md text-on-surface mb-6 border-b border-surface-container pb-4">Pengaturan &amp; Privasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div>
            <h3 class="font-label-sm text-label-sm text-on-surface-variant mb-4 uppercase tracking-wider">Keamanan Akun</h3>
            <ul class="space-y-4">
              <li>
                <router-link to="/profile/settings/password" class="w-full flex items-center justify-between p-3 hover:bg-surface-container rounded-xl transition-colors text-left group">
                  <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">password</span>
                    <span class="font-body-md text-body-md text-on-surface">Ubah Kata Sandi</span>
                  </div>
                  <span class="material-symbols-outlined text-secondary group-hover:translate-x-1 transition-transform">chevron_right</span>
                </router-link>
              </li>
              <li>
                <router-link to="/profile/settings/2fa" class="w-full flex items-center justify-between p-3 hover:bg-surface-container rounded-xl transition-colors text-left group">
                  <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">security</span>
                    <span class="font-body-md text-body-md text-on-surface">Autentikasi Dua Langkah (2FA)</span>
                  </div>
                  <span class="material-symbols-outlined text-secondary group-hover:translate-x-1 transition-transform">chevron_right</span>
                </router-link>
              </li>
            </ul>
          </div>
          <div>
            <h3 class="font-label-sm text-label-sm text-on-surface-variant mb-4 uppercase tracking-wider">Privasi Data</h3>
            <ul class="space-y-4">
              <li>
                <router-link to="/profile/settings/privacy" class="w-full flex items-center justify-between p-3 hover:bg-surface-container rounded-xl transition-colors text-left group">
                  <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">visibility</span>
                    <span class="font-body-md text-body-md text-on-surface">Visibilitas Profil</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="text-sm text-on-surface-variant bg-surface-container-high px-2 py-1 rounded">Publik</span>
                    <span class="material-symbols-outlined text-secondary group-hover:translate-x-1 transition-transform">chevron_right</span>
                  </div>
                </router-link>
              </li>
              <li>
                <router-link to="/profile/settings/privacy" class="w-full flex items-center justify-between p-3 hover:bg-surface-container rounded-xl transition-colors text-left group">
                  <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">download</span>
                    <span class="font-body-md text-body-md text-on-surface">Unduh Data Saya</span>
                  </div>
                  <span class="material-symbols-outlined text-secondary group-hover:translate-x-1 transition-transform">chevron_right</span>
                </router-link>
              </li>
            </ul>
          </div>
        </div>
        <div class="mt-8 pt-6 border-t border-surface-container flex justify-end">
          <button class="px-6 py-2 bg-error-container text-on-error-container rounded-xl font-label-sm text-label-sm hover:bg-error hover:text-on-error transition-colors">
            Hapus Akun
          </button>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
</script>

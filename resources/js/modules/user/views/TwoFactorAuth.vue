<template>
  <div>
    <header class="mb-8 flex items-center gap-4">
      <router-link to="/profile" class="p-2 hover:bg-surface-container rounded-full transition-colors flex items-center justify-center">
        <span class="material-symbols-outlined text-on-surface">arrow_back</span>
      </router-link>
      <div>
        <h1 class="font-headline-md text-headline-md text-on-surface">Autentikasi Dua Langkah (2FA)</h1>
        <p class="text-on-surface-variant font-body-md text-body-md">Tambahkan lapisan keamanan ekstra pada akun Anda</p>
      </div>
    </header>

    <div class="bg-surface rounded-3xl p-6 md:p-8 shadow-[0px_20px_40px_rgba(0,0,0,0.08)] max-w-2xl">
      
      <div class="flex flex-col md:flex-row gap-8 items-center md:items-start mb-8 pb-8 border-b border-surface-container">
        <div class="w-24 h-24 rounded-full bg-primary-container/20 flex items-center justify-center shrink-0">
          <span class="material-symbols-outlined text-primary text-4xl">security</span>
        </div>
        <div>
          <h2 class="font-headline-md text-on-surface mb-2">Lindungi akun Anda dari akses tidak sah</h2>
          <p class="text-on-surface-variant text-body-md mb-4">
            Saat 2FA aktif, Anda akan diminta memasukkan kode unik yang dikirimkan ke perangkat Anda setiap kali Anda login dari perangkat baru.
          </p>
          <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container-high rounded-full">
            <div class="w-2 h-2 rounded-full bg-error"></div>
            <span class="text-sm font-medium text-on-surface-variant">Status: Nonaktif</span>
          </div>
        </div>
      </div>

      <div class="flex flex-col gap-4">
        <h3 class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Metode Autentikasi</h3>
        
        <div class="flex items-center justify-between p-4 border border-surface-container rounded-xl">
          <div class="flex items-center gap-4">
            <span class="material-symbols-outlined text-secondary text-2xl">smartphone</span>
            <div>
              <div class="font-body-md text-on-surface font-medium">Aplikasi Authenticator</div>
              <div class="text-sm text-on-surface-variant">Gunakan Google Authenticator atau Authy</div>
            </div>
          </div>
          <button class="px-4 py-2 bg-primary text-on-primary font-label-sm text-label-sm rounded-lg hover:shadow-md transition-all">
            Siapkan
          </button>
        </div>

        <div class="flex items-center justify-between p-4 border border-surface-container rounded-xl">
          <div class="flex items-center gap-4">
            <span class="material-symbols-outlined text-secondary text-2xl">mail</span>
            <div>
              <div class="font-body-md text-on-surface font-medium">Kode via Email</div>
              <div class="text-sm text-on-surface-variant">alex.johnson@student.edu</div>
            </div>
          </div>
          <button class="px-4 py-2 bg-surface-container-high text-on-surface font-label-sm text-label-sm rounded-lg hover:bg-surface-container-highest transition-all">
            Aktifkan
          </button>
        </div>
      </div>
      
    </div>
  </div>
</template>

<script setup>
// 2FA settings component
</script>

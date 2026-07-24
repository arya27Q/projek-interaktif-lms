<template>
  <div class="bg-background text-on-surface min-h-screen overflow-x-hidden">
    
    <!-- TopNavBar (Mobile Only) -->
    <nav class="md:hidden fixed top-floating-gap left-floating-gap right-floating-gap z-50 flex justify-between items-center px-gutter py-unit h-16 bg-surface/80 dark:bg-inverse-surface/80 backdrop-blur-md rounded-xl m-floating-gap shadow-[0px_10px_30px_rgba(0,0,0,0.04)]">
      <div class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed-dim">NexLearn</div>
      <div class="flex items-center gap-4 relative">
        <button class="text-on-surface-variant dark:text-on-secondary-fixed-variant hover:bg-surface-container dark:hover:bg-secondary-container transition-all duration-200 active:scale-95 p-2 rounded-full">
          <span class="material-symbols-outlined">notifications</span>
        </button>
        <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="focus:outline-none rounded-full">
          <img alt="User profile" class="w-8 h-8 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDMx_rL2GZkuoEJIXlW3MmTRQwk2eQdnOXt-DjyV6locEOq4BiDrvCioDR4iGOgoxaUb6tbKxlqwV8h90wAwULBwrCADGCHFAPEF_JsljzN6vjBSNUT7wDNgO0Cc8vuhRhlDVvR-WqpbbxEPjYGWiXtEGZF0PZS9aQNgTeIJfgQJeebQKMespvlJEy_3MK3NCVIzmU73tSeu3iObfsi1Lmv4oE0PVr4SoTAeKgcYR888lpkkjND5VnnYPIHPsySo9vwVDShj9mSmxSB"/>
        </button>

        <!-- Dropdown Mobile Menu -->
        <div v-if="isMobileMenuOpen" class="absolute top-12 right-0 w-48 bg-surface-container-lowest border border-surface-container-low rounded-xl shadow-[0px_20px_40px_rgba(0,0,0,0.1)] py-2 flex flex-col z-50">
          <button @click="isMobileMenuOpen = false" class="w-full text-left px-4 py-3 text-primary font-bold hover:bg-surface-container flex items-center gap-3 border-b border-surface-container-low text-sm transition-colors">
            <span class="material-symbols-outlined text-[20px]">star</span> Upgrade to Pro
          </button>
          <router-link @click="isMobileMenuOpen = false" to="/profile/settings/privacy" class="px-4 py-3 text-secondary hover:text-primary hover:bg-surface-container flex items-center gap-3 text-sm transition-colors">
            <span class="material-symbols-outlined text-[20px]">settings</span> Settings
          </router-link>
          <router-link @click="isMobileMenuOpen = false" to="/login" class="px-4 py-3 text-secondary hover:text-primary hover:bg-surface-container flex items-center gap-3 border-t border-surface-container-low text-sm transition-colors">
            <span class="material-symbols-outlined text-[20px]">logout</span> Logout
          </router-link>
        </div>
      </div>
    </nav>
    
    <!-- Transparent Overlay to close mobile menu -->
    <div v-if="isMobileMenuOpen" @click="isMobileMenuOpen = false" class="md:hidden fixed inset-0 z-40"></div>
    
    <!-- Sidebar Navigation Shell (Desktop) -->
    <aside class="hidden lg:flex flex-col fixed left-0 top-0 z-40 bg-surface-container-lowest rounded-lg m-floating-gap h-[calc(100vh-40px)] w-64 shadow-[0px_10px_30px_rgba(0,0,0,0.04)] border border-surface-container-low">
      <div class="p-6 flex flex-col h-full">
        <!-- Brand Header -->
        <div class="mb-10">
          <h1 class="font-display-lg text-display-lg text-primary">NexLearn</h1>
          <p class="font-body-md text-secondary mt-1">Level 12 • 2,450 EXP</p>
        </div>
        <!-- Main Tabs -->
        <nav class="flex-1 space-y-2">
          <router-link to="/" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low hover:text-primary transition-all duration-200" exact-active-class="!text-primary font-bold bg-surface-container-low">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-body-md">Dashboard</span>
          </router-link>
          <router-link to="/courses" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low hover:text-primary transition-all duration-200" active-class="!text-primary font-bold bg-surface-container-low">
            <span class="material-symbols-outlined">school</span>
            <span class="font-body-md">Kursus Saya</span>
          </router-link>
          <router-link to="/catalog" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low hover:text-primary transition-all duration-200" active-class="!text-primary font-bold bg-surface-container-low">
            <span class="material-symbols-outlined">library_books</span>
            <span class="font-body-md">Katalog</span>
          </router-link>
          <router-link to="/instructor" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low hover:text-primary transition-all duration-200" active-class="!text-primary font-bold bg-surface-container-low">
            <span class="material-symbols-outlined">video_settings</span>
            <span class="font-body-md">Studio Instruktur</span>
          </router-link>
        </nav>
        <!-- CTA -->
        <div class="mt-auto mb-6">
          <router-link to="/upgrade" class="flex items-center justify-center gap-2 w-full py-3 px-4 bg-primary text-on-primary font-label-sm rounded-lg hover:-translate-y-0.5 active:scale-95 transition-transform">
            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
            Upgrade ke Pro
          </router-link>
        </div>
        <!-- Footer Tabs -->
        <div class="space-y-2 border-t border-surface-container-low pt-4">
          <router-link to="/profile" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low hover:text-primary transition-all duration-200" active-class="!text-primary font-bold bg-surface-container-low">
            <span class="material-symbols-outlined">person</span>
            <span class="font-body-md">Profil</span>
          </router-link>
          <router-link to="/profile/settings/privacy" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low hover:text-primary transition-all duration-200" active-class="!text-primary font-bold bg-surface-container-low">
            <span class="material-symbols-outlined">settings</span>
            <span class="font-body-md">Pengaturan</span>
          </router-link>
          <router-link to="/login" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low hover:text-primary transition-all duration-200">
            <span class="material-symbols-outlined">logout</span>
            <span class="font-body-md">Keluar</span>
          </router-link>
        </div>
      </div>
    </aside>

    <!-- Top Navigation Bar (Desktop) -->
    <header class="hidden lg:flex items-center justify-between fixed top-0 right-0 left-64 z-30 px-8 h-16 ml-floating-gap mr-floating-gap mt-floating-gap bg-surface-container-lowest rounded-lg shadow-[0px_10px_30px_rgba(0,0,0,0.04)] border border-surface-container-low">
      <!-- Search Bar Area -->
      <div class="flex-1 max-w-md relative focus-within:max-w-xl transition-all duration-300">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-secondary text-[20px]">search</span>
        <input class="w-full pl-10 pr-4 py-2 bg-surface-container-low border-transparent rounded-full font-label-sm text-on-surface focus:border-primary focus:ring-0 transition-all outline-none" placeholder="Cari kursus, topik, atau keahlian..." type="text"/>
      </div>
      <!-- Trailing Actions -->
      <div class="flex items-center gap-6 ml-4">
        <div class="flex items-center gap-2 px-4 py-1.5 bg-tertiary-fixed text-on-tertiary-fixed rounded-full font-label-sm">
          <span class="material-symbols-outlined text-[18px]">local_fire_department</span>
          <span>Streak 12 Hari</span>
        </div>
        <button class="relative p-2 text-secondary hover:bg-surface-container-low rounded-full transition-all">
          <span class="material-symbols-outlined">notifications</span>
          <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
        </button>
        <router-link to="/profile" class="h-10 w-10 rounded-full bg-surface-container-high overflow-hidden border border-surface-variant hover:border-primary transition-colors block">
          <img class="w-full h-full object-cover" alt="Profile" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDMx_rL2GZkuoEJIXlW3MmTRQwk2eQdnOXt-DjyV6locEOq4BiDrvCioDR4iGOgoxaUb6tbKxlqwV8h90wAwULBwrCADGCHFAPEF_JsljzN6vjBSNUT7wDNgO0Cc8vuhRhlDVvR-WqpbbxEPjYGWiXtEGZF0PZS9aQNgTeIJfgQJeebQKMespvlJEy_3MK3NCVIzmU73tSeu3iObfsi1Lmv4oE0PVr4SoTAeKgcYR888lpkkjND5VnnYPIHPsySo9vwVDShj9mSmxSB"/>
        </router-link>
      </div>
    </header>

    <!-- Main Content Canvas -->
    <main class="pt-24 lg:pt-28 px-4 md:px-8 pb-32 min-h-screen lg:ml-74 max-w-container-max mx-auto">
      <router-view v-slot="{ Component }">
        <transition name="page" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </main>

    <!-- Mobile Bottom Navigation Shell -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 h-20 bg-surface-container-lowest flex items-center justify-around px-4 shadow-[0px_-10px_30px_rgba(0,0,0,0.04)] z-50">
      <router-link to="/" class="flex flex-col items-center gap-1 text-secondary" exact-active-class="!text-primary font-bold">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="text-[10px] font-label-sm">Beranda</span>
      </router-link>
      <router-link to="/catalog" class="flex flex-col items-center gap-1 text-secondary" active-class="!text-primary font-bold">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">library_books</span>
        <span class="text-[10px] font-label-sm">Katalog</span>
      </router-link>
      <router-link to="/courses" class="flex flex-col items-center gap-1 text-secondary" active-class="!text-primary font-bold">
        <span class="material-symbols-outlined">school</span>
        <span class="text-[10px] font-label-sm">Kursus</span>
      </router-link>
      <router-link to="/instructor" class="flex flex-col items-center gap-1 text-secondary" active-class="!text-primary font-bold">
        <span class="material-symbols-outlined">video_settings</span>
        <span class="text-[10px] font-label-sm">Studio</span>
      </router-link>
      <router-link to="/profile" class="flex flex-col items-center gap-1 text-secondary" active-class="!text-primary font-bold">
        <span class="material-symbols-outlined">person</span>
        <span class="text-[10px] font-label-sm">Profil</span>
      </router-link>
    </nav>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const isMobileMenuOpen = ref(false);
</script>

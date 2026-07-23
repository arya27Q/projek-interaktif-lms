<template>
  <div class="bg-background text-on-surface min-h-screen overflow-x-hidden">
    
    <!-- TopNavBar (Mobile Only) -->
    <nav class="md:hidden fixed top-floating-gap left-floating-gap right-floating-gap z-50 flex justify-between items-center px-gutter py-unit h-16 bg-surface/80 dark:bg-inverse-surface/80 backdrop-blur-md rounded-xl m-floating-gap shadow-[0px_10px_30px_rgba(0,0,0,0.04)]">
      <div class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed-dim">NexLearn</div>
      <div class="flex items-center gap-4">
        <button class="text-on-surface-variant dark:text-on-secondary-fixed-variant hover:bg-surface-container dark:hover:bg-secondary-container transition-all duration-200 active:scale-95 p-2 rounded-full">
          <span class="material-symbols-outlined">notifications</span>
        </button>
        <img alt="User profile" class="w-8 h-8 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDMx_rL2GZkuoEJIXlW3MmTRQwk2eQdnOXt-DjyV6locEOq4BiDrvCioDR4iGOgoxaUb6tbKxlqwV8h90wAwULBwrCADGCHFAPEF_JsljzN6vjBSNUT7wDNgO0Cc8vuhRhlDVvR-WqpbbxEPjYGWiXtEGZF0PZS9aQNgTeIJfgQJeebQKMespvlJEy_3MK3NCVIzmU73tSeu3iObfsi1Lmv4oE0PVr4SoTAeKgcYR888lpkkjND5VnnYPIHPsySo9vwVDShj9mSmxSB"/>
      </div>
    </nav>
    
    <!-- Sidebar Navigation Shell (Desktop) -->
    <aside class="flex flex-col fixed left-0 top-0 z-40 bg-surface-container-lowest rounded-lg m-floating-gap h-[calc(100vh-40px)] w-64 shadow-[0px_10px_30px_rgba(0,0,0,0.04)] border border-surface-container-low hidden lg:flex">
      <div class="p-6 flex flex-col h-full">
        <!-- Brand Header -->
        <div class="mb-10">
          <h1 class="font-display-lg text-display-lg text-primary">NexLearn</h1>
          <p class="font-body-md text-secondary mt-1">Level 12 • 2,450 EXP</p>
        </div>
        <!-- Main Tabs -->
        <nav class="flex-1 space-y-2">
          <router-link to="/" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low transition-all duration-200" exact-active-class="text-primary font-bold bg-surface-container-low">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-body-md">Dashboard</span>
          </router-link>
          <router-link to="/courses" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low transition-all duration-200" active-class="text-primary font-bold bg-surface-container-low">
            <span class="material-symbols-outlined">school</span>
            <span class="font-body-md">Courses</span>
          </router-link>
          <router-link to="/catalog" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low transition-all duration-200" active-class="text-primary font-bold bg-surface-container-low">
            <span class="material-symbols-outlined">library_books</span>
            <span class="font-body-md">Catalog</span>
          </router-link>
          <router-link to="/instructor" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low transition-all duration-200" active-class="text-primary font-bold bg-surface-container-low">
            <span class="material-symbols-outlined">video_settings</span>
            <span class="font-body-md">Instructor Studio</span>
          </router-link>
        </nav>
        <!-- CTA -->
        <div class="mt-auto mb-6">
          <button class="w-full py-3 px-4 bg-primary text-on-primary font-label-sm rounded-lg hover:-translate-y-0.5 active:scale-95 transition-transform">
            Upgrade to Pro
          </button>
        </div>
        <!-- Footer Tabs -->
        <div class="space-y-2 border-t border-surface-container-low pt-4">
          <router-link to="/profile" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low transition-all duration-200" active-class="text-primary font-bold bg-surface-container-low">
            <span class="material-symbols-outlined">person</span>
            <span class="font-body-md">Profile</span>
          </router-link>
          <router-link to="/profile/settings/privacy" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low transition-all duration-200" active-class="text-primary font-bold bg-surface-container-low">
            <span class="material-symbols-outlined">settings</span>
            <span class="font-body-md">Settings</span>
          </router-link>
          <router-link to="/login" class="flex items-center gap-3 p-3 rounded-lg text-secondary hover:bg-surface-container-low transition-all duration-200">
            <span class="material-symbols-outlined">logout</span>
            <span class="font-body-md">Logout</span>
          </router-link>
        </div>
      </div>
    </aside>

    <!-- Top Navigation Bar (Desktop) -->
    <header class="hidden lg:flex items-center justify-between fixed top-0 right-0 left-64 z-30 px-8 h-16 ml-floating-gap mr-floating-gap mt-floating-gap bg-surface-container-lowest rounded-lg shadow-[0px_10px_30px_rgba(0,0,0,0.04)] border border-surface-container-low">
      <!-- Search Bar Area -->
      <div class="flex-1 max-w-md relative focus-within:max-w-xl transition-all duration-300">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-secondary text-[20px]">search</span>
        <input class="w-full pl-10 pr-4 py-2 bg-surface-container-low border-transparent rounded-full font-label-sm text-on-surface focus:border-primary focus:ring-0 transition-all outline-none" placeholder="Search for courses, tags, or skills..." type="text"/>
      </div>
      <!-- Trailing Actions -->
      <div class="flex items-center gap-6 ml-4">
        <div class="flex items-center gap-2 px-4 py-1.5 bg-tertiary-fixed text-on-tertiary-fixed rounded-full font-label-sm">
          <span class="material-symbols-outlined text-[18px]">local_fire_department</span>
          <span>12 Day Streak</span>
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
    <main class="pt-24 lg:pt-28 px-4 md:px-8 pb-32 min-h-screen lg:ml-[296px] max-w-container-max mx-auto">
      <router-view></router-view>
    </main>

    <!-- Mobile Bottom Navigation Shell -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 h-20 bg-surface-container-lowest flex items-center justify-around px-4 shadow-[0px_-10px_30px_rgba(0,0,0,0.04)] z-50">
      <router-link to="/" class="flex flex-col items-center gap-1 text-secondary" exact-active-class="text-primary font-bold">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="text-[10px] font-label-sm">Home</span>
      </router-link>
      <router-link to="/catalog" class="flex flex-col items-center gap-1 text-secondary" active-class="text-primary font-bold">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">library_books</span>
        <span class="text-[10px] font-label-sm">Catalog</span>
      </router-link>
      <router-link to="/courses" class="flex flex-col items-center gap-1 text-secondary" active-class="text-primary font-bold">
        <span class="material-symbols-outlined">school</span>
        <span class="text-[10px] font-label-sm">My Learning</span>
      </router-link>
      <router-link to="/profile" class="flex flex-col items-center gap-1 text-secondary" active-class="text-primary font-bold">
        <span class="material-symbols-outlined">person</span>
        <span class="text-[10px] font-label-sm">Profile</span>
      </router-link>
    </nav>
  </div>
</template>

<script setup>
</script>

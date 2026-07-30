<template>
  <div class="space-y-10">
    <!-- Hero Section: Course Progress -->
    <div class="mb-4">
      <h2 class="font-display-lg text-on-surface text-[32px] md:text-[36px] mb-2">Selamat Datang Kembali, Alex!</h2>
      <p class="font-body-md text-secondary">Kamu sudah belajar 12 hari berturut-turut — pertahankan!</p>
    </div>
    
    <section class="relative overflow-hidden bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-[0px_10px_30px_rgba(0,0,0,0.04)] border border-surface-container-low hover:shadow-lg transition-shadow duration-300">
      <div class="relative z-10 grid md:grid-cols-2 gap-8 items-center">
        <div>
          <span class="inline-block px-3 py-1 bg-primary/10 text-primary rounded-full text-[12px] font-bold mb-4 uppercase tracking-wider">Kursus Aktif</span>
          <h2 class="font-display-lg text-on-surface mb-3 text-[28px] md:text-[36px] leading-tight">Laravel Eloquent</h2>
          <p class="font-body-md text-secondary mb-8 max-w-md">Kuasai relasi database yang kompleks dan teknik query tingkat lanjut. Kamu sudah hampir sampai di garis akhir!</p>
          <div class="space-y-4">
            <div class="flex justify-between items-end">
              <span class="font-label-sm text-on-surface font-bold">65% Selesai</span>
              <span class="font-label-sm text-secondary">24 / 36 pelajaran</span>
            </div>
            <div class="w-full h-3 bg-surface-container-low rounded-full overflow-hidden">
              <div class="h-full bg-primary w-[65%] rounded-full shadow-[0_0_15px_rgba(0,88,190,0.3)]"></div>
            </div>
          </div>
          <div class="mt-8 flex flex-wrap gap-4">
            <button class="bg-primary text-on-primary px-8 py-3 rounded-xl font-label-sm hover:bg-on-surface hover:-translate-y-1 transition-all duration-300 shadow-lg active:scale-95">
              Lanjutkan Pelajaran
            </button>
            <button class="text-on-surface px-8 py-3 border border-outline-variant rounded-xl font-label-sm hover:bg-surface-container-low transition-all">
              Lihat Kurikulum
            </button>
          </div>
        </div>
        <div class="hidden md:block relative h-64 lg:h-72 rounded-xl overflow-hidden">
          <img class="w-full h-full object-cover rounded-xl grayscale hover:grayscale-0 transition-all duration-700" alt="Code Editor" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCMUluWjJEX_VrTpkv69ZewyvRM-MtmvNjYxMbphFfgib11KkVqgqTiatMNCjXBufulak0Rfmn3aeab74oCRBTCKAAvW-xDzfjXrAAg3ep-d-clXMAOvRUU1t9mKin4qsK_W51zs7v5xdti5i6BPQewmbFTXq9uG0Qp8mnBcxq7VVJ2zR_O9MQHvIWfziz8y-OyT2uObl5xEyD3FY7RdAYOTpMJen1ivbRfxljsC2JV8kw9O7i_sOQbafcfivH4lrFll1v9D7JeC1Dq">
          <div class="absolute inset-0 bg-linear-to-t from-surface-container-lowest/20 to-transparent"></div>
        </div>
      </div>
      <!-- Decorative element -->
      <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
    </section>

    <!-- Gamification & Stats Bento -->
    <section class="grid grid-cols-12 gap-4 md:gap-6">
      <!-- Streak Widget -->
      <div class="col-span-12 md:col-span-4 bg-surface-container-lowest p-6 md:p-8 rounded-2xl shadow-[0px_10px_30px_rgba(0,0,0,0.04)] border border-surface-container-low hover-lift">
        <div class="flex items-center justify-between mb-6">
          <div class="w-12 h-12 rounded-2xl bg-tertiary-fixed flex items-center justify-center">
            <span class="material-symbols-outlined text-on-tertiary-fixed text-2xl" style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
          </div>
          <span class="text-tertiary font-bold">Aktivitas</span>
        </div>
        <StreakWidget />
      </div>

      <!-- EXP Widget -->
      <div class="col-span-12 md:col-span-4 bg-on-surface p-6 md:p-8 rounded-2xl shadow-[0px_20px_40px_rgba(0,0,0,0.08)] text-surface-container-lowest hover-lift relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-primary/20 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative z-10">
          <div class="flex items-center justify-between mb-6">
            <div class="w-12 h-12 rounded-2xl bg-primary flex items-center justify-center">
              <span class="material-symbols-outlined text-on-primary text-2xl">bolt</span>
            </div>
            <span class="text-primary-fixed font-bold bg-primary/20 px-2 py-1 rounded text-xs">Top 5%</span>
          </div>
          <p class="font-label-sm text-surface-variant mb-1">Total Pengalaman</p>
          <h3 class="font-display-lg text-surface-container-lowest text-[28px] md:text-[32px]">2,450 <span class="text-[16px] font-normal text-surface-variant">EXP</span></h3>
          <div class="mt-6">
            <p class="text-xs text-surface-variant mb-2">550 EXP lagi menuju Level 13</p>
            <div class="w-full h-1.5 bg-surface-variant/20 rounded-full">
              <div class="h-full bg-primary w-[78%] rounded-full"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Rank Widget -->
      <div class="col-span-12 md:col-span-4 bg-surface-container-lowest p-6 md:p-8 rounded-2xl shadow-[0px_10px_30px_rgba(0,0,0,0.04)] border border-surface-container-low hover-lift">
        <div class="flex items-center justify-between mb-6">
          <div class="w-12 h-12 rounded-2xl bg-surface-container-low flex items-center justify-center">
            <span class="material-symbols-outlined text-on-surface text-2xl">workspace_premium</span>
          </div>
          <span class="text-secondary font-bold">Global</span>
        </div>
        <p class="font-label-sm text-secondary mb-1">Peringkat Saat Ini</p>
        <h3 class="font-display-lg text-on-surface text-[28px] md:text-[32px]">Scholar</h3>
        <p class="mt-6 text-xs text-secondary leading-relaxed">Kamu membuka lencana <span class="text-primary font-bold">Pola Lanjutan</span> minggu ini.</p>
      </div>

      <!-- Leaderboard Preview -->
      <div class="col-span-12 bg-surface-container-lowest p-6 md:p-8 rounded-2xl shadow-[0px_10px_30px_rgba(0,0,0,0.04)] border border-surface-container-low hover-lift">
        <div class="flex items-center justify-between mb-6">
          <h3 class="font-headline-md text-on-surface text-[18px]">Papan Peringkat</h3>
          <a href="#" class="text-primary font-label-sm hover:underline">Lihat Semua</a>
        </div>
        <Leaderboard />
      </div>
    </section>

    <!-- Active Courses Cards -->
    <section>
      <div class="flex items-center justify-between mb-8">
        <h3 class="font-headline-md text-on-surface text-xl">Kursus Aktif</h3>
        <router-link to="/catalog" class="text-primary font-label-sm hover:underline flex items-center gap-1">
          Jelajahi semua kursus
          <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </router-link>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        
        <!-- Course Card 1 -->
        <router-link to="/course/1" class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-[0px_20px_40px_rgba(0,0,0,0.08)] hover-lift border border-surface-container-low group cursor-pointer block">
          <div class="h-48 w-full bg-surface-container-high relative overflow-hidden">
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="React" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9iaHz4S5U_8bGKTgX-p5yZmNHTdWTV9UcUDOMsCKC0-UbA2aOY8IyUwq0zxKZId6qGmWFFKqirTUhrw7vK6TOjMk7-R4JMQ_HRde2cUPMqBdlP2u5EK4OXCz4a53rnMTEm3pEcXheM2Om1-3XFO0f0Ol1Jmce0ytTFnTvM7d7MTc9Mo8z3BC1YlyoGBdobIOBtEzSZOjbC-CCF3ID4FsDFYN4hlz37rm4ayS1jMGYxQ1_tuBsBIKCfecWP2KigcH5-kLZpfFILk8Z">
            <div class="absolute top-4 left-4 bg-on-surface/80 backdrop-blur-md text-white text-[10px] font-bold px-2 py-1 rounded tracking-wider">INTERMEDIATE</div>
          </div>
          <div class="p-6">
            <h4 class="font-headline-md text-on-surface text-[18px] mb-2 group-hover:text-primary transition-colors">Pola React Tingkat Lanjut</h4>
            <p class="text-secondary font-body-md text-sm mb-6 line-clamp-2">Menyelami hooks, HOC, dan render props untuk aplikasi yang scalable.</p>
            <div class="flex items-center justify-between">
              <div class="flex -space-x-2">
                <div class="w-8 h-8 rounded-full border-2 border-surface-container-lowest bg-surface-container-high overflow-hidden"><img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover"></div>
                <div class="w-8 h-8 rounded-full border-2 border-surface-container-lowest bg-surface-container-low overflow-hidden"><img src="https://images.unsplash.com/photo-1598550874175-4d0ef436c909?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover"></div>
                <div class="flex items-center justify-center w-8 h-8 rounded-full border-2 border-surface-container-lowest bg-primary-fixed text-on-primary-fixed-variant text-[10px] font-bold">+12</div>
              </div>
              <span class="font-label-sm text-on-surface font-bold">42%</span>
            </div>
            <div class="mt-4 w-full h-1.5 bg-surface-container-low rounded-full overflow-hidden">
              <div class="h-full bg-primary w-[42%]"></div>
            </div>
          </div>
        </router-link>

        <!-- Course Card 2 -->
        <router-link to="/course/2" class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-[0px_20px_40px_rgba(0,0,0,0.08)] hover-lift border border-surface-container-low group cursor-pointer block">
          <div class="h-48 w-full bg-surface-container-high relative overflow-hidden">
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="UI Foundations" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBA6w8qlF5sgrwYLx1OSnxmGehqOnDMxs_qXQfcV2bbv1E8WnQHFj9GpIoT1g29YcVI6pm-vYkMUjTmElzcs4g8PLaQvq2kDTsYrg6AKY-0qXoJBkjg7yJhta6LjrCusYUDOObn0fjyfqZb_seE0dBLR6J8lpQ_Gw6Cymcn7PNAjz1JcdrV3xZCn7EOCIbRtHpt9rdpzKAYKVKLXKSQFfSBDRh7LahB58c0iEiYsXZT4UnHZ2ezX3aaiyNE4YplX38eDO64QX5ZMCYC">
            <div class="absolute top-4 left-4 bg-on-surface/80 backdrop-blur-md text-white text-[10px] font-bold px-2 py-1 rounded tracking-wider">BEGINNER</div>
          </div>
          <div class="p-6">
            <h4 class="font-headline-md text-on-surface text-[18px] mb-2 group-hover:text-primary transition-colors">Dasar-Dasar UI Modern</h4>
            <p class="text-secondary font-body-md text-sm mb-6 line-clamp-2">Pelajari prinsip tipografi, spasi, dan hierarki visual yang baik.</p>
            <div class="flex items-center justify-between">
              <div class="flex -space-x-2">
                <div class="w-8 h-8 rounded-full border-2 border-surface-container-lowest bg-surface-container-high overflow-hidden"><img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover"></div>
              </div>
              <span class="font-label-sm text-on-surface font-bold">88%</span>
            </div>
            <div class="mt-4 w-full h-1.5 bg-surface-container-low rounded-full overflow-hidden">
              <div class="h-full bg-primary w-[88%]"></div>
            </div>
          </div>
        </router-link>

        <!-- Course Card 3 -->
        <router-link to="/course/3" class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-[0px_20px_40px_rgba(0,0,0,0.08)] hover-lift border border-surface-container-low group cursor-pointer block">
          <div class="h-48 w-full bg-surface-container-high relative overflow-hidden">
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Systems Arch" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD02AtMsd0XsGixJ9HhOJeVUnGRDAQZbKeYCMEhxGn2qMUw5SS4uHxJ4hxHaWzK4RllnP2S4JW1Opus3s2r0O5E1cpzhcc-XFKlQTwvNw2-TY2dOGFoMaYA_duym2QqAXxiHcRvLTCSq230A3ikFCHlGGImvApYt6Z9w0nTKM6XlzudCEF-b3ntrIq8PcWGCTUJDs8xglOxAKoRT8R6vvQskIJGqdawcocFw46Yd2ki4iovgm2H7B8spCFoWZOP_XrYQKbI1IxXAWgC">
            <div class="absolute top-4 left-4 bg-on-surface/80 backdrop-blur-md text-white text-[10px] font-bold px-2 py-1 rounded tracking-wider">ADVANCED</div>
          </div>
          <div class="p-6">
            <h4 class="font-headline-md text-on-surface text-[18px] mb-2 group-hover:text-primary transition-colors">Arsitektur Sistem</h4>
            <p class="text-secondary font-body-md text-sm mb-6 line-clamp-2">Merancang sistem terdistribusi yang scalable dan arsitektur microservices.</p>
            <div class="flex items-center justify-between">
              <div class="flex -space-x-2">
                <div class="w-8 h-8 rounded-full border-2 border-surface-container-lowest bg-surface-container-high overflow-hidden"><img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover"></div>
                <div class="w-8 h-8 rounded-full border-2 border-surface-container-lowest bg-surface-container-low overflow-hidden"><img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover"></div>
              </div>
              <span class="font-label-sm text-on-surface font-bold">15%</span>
            </div>
            <div class="mt-4 w-full h-1.5 bg-surface-container-low rounded-full overflow-hidden">
              <div class="h-full bg-primary w-[15%]"></div>
            </div>
          </div>
        </router-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import StreakWidget from '@/modules/gamification/components/StreakWidget.vue';
import Leaderboard from '@/modules/gamification/components/Leaderboard.vue';

// Dashboard logic can be added here
</script>

<style scoped>
.hover-lift {
  transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease;
}
.hover-lift:hover {
  transform: translateY(-4px);
}
</style>

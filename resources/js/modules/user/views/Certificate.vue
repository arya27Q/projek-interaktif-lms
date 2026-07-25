<template>
  <div class="max-w-4xl mx-auto pb-10">
    
    <!-- Action Header -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
      <button @click="$router.back()" class="w-10 h-10 rounded-full bg-surface-container-lowest border border-surface-container-low flex items-center justify-center text-secondary hover:text-primary transition-colors shrink-0">
        <span class="material-symbols-outlined">arrow_back</span>
      </button>
      
      <div class="flex items-center gap-3">
        <button class="px-5 py-2.5 bg-surface-container-lowest border border-surface-container-low text-secondary font-bold text-sm rounded-lg hover:text-primary transition-colors flex items-center gap-2">
          <span class="material-symbols-outlined text-[18px]">share</span> Bagikan
        </button>
        <button class="px-5 py-2.5 bg-primary text-white font-bold text-sm rounded-lg hover:shadow-lg transition-all active:scale-95 flex items-center gap-2">
          <span class="material-symbols-outlined text-[18px]">download</span> Unduh PDF
        </button>
      </div>
    </div>

    <!-- Certificate Container -->
    <div class="relative bg-white border-12 border-surface-container-low p-2 rounded-lg shadow-2xl overflow-hidden aspect-[1.414/1] flex items-center justify-center text-center">
      
      <!-- Inner Border -->
      <div class="absolute inset-4 border-2 border-primary/20 p-8 flex flex-col items-center justify-center overflow-hidden bg-[radial-gradient(ellipse_at_top_right,var(--tw-gradient-stops))] from-primary/5 via-white to-white">
        
        <!-- Watermark / Background element -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-[0.03] pointer-events-none">
          <span class="material-symbols-outlined text-[400px]">workspace_premium</span>
        </div>
        
        <div class="relative z-10 w-full flex flex-col items-center">
          
          <!-- Header Logo -->
          <h2 class="text-3xl font-black text-primary tracking-widest uppercase mb-10">NexLearn</h2>
          
          <!-- Certificate Title -->
          <div class="mb-10">
            <h1 class="text-4xl md:text-5xl font-serif text-on-surface mb-2" style="font-family: 'Playfair Display', serif;">Sertifikat Kelulusan</h1>
            <p class="text-secondary tracking-[0.2em] uppercase text-sm font-bold">Diberikan secara resmi kepada</p>
          </div>
          
          <!-- Recipient Name -->
          <h2 class="text-5xl md:text-6xl font-bold text-primary mb-8 border-b-2 border-primary/20 pb-4 px-10 inline-block" style="font-family: 'Great Vibes', cursive, serif;">
            Arya Pratama
          </h2>
          
          <!-- Description -->
          <p class="text-secondary text-sm md:text-base max-w-xl leading-relaxed mb-12">
            Telah berhasil menyelesaikan seluruh rangkaian materi, kuis, dan tugas akhir dengan predikat <span class="font-bold text-on-surface">Sangat Baik</span> pada program kursus:
          </p>
          
          <!-- Course Title -->
          <h3 class="text-2xl font-bold text-on-surface mb-16">
            Mastering Advanced CSS Layouts & Animation
          </h3>
          
          <!-- Footer Details -->
          <div class="flex items-end justify-between w-full px-12 mt-auto">
            
            <!-- Date & ID -->
            <div class="text-left">
              <p class="font-bold text-on-surface border-b border-surface-container-high pb-2 mb-2 px-4 inline-block min-w-37.5 text-center">25 Juli 2026</p>
              <p class="text-xs text-secondary uppercase tracking-wider">Tanggal Lulus</p>
              <p class="text-[9px] text-secondary/50 mt-4 font-mono">ID: NXL-2026-889021A</p>
            </div>
            
            <!-- Seal/Badge -->
            <div class="w-24 h-24 bg-primary text-white rounded-full flex flex-col items-center justify-center shadow-lg border-4 border-white transform rotate-12 relative z-20">
              <span class="material-symbols-outlined text-[32px] mb-1">verified</span>
              <span class="text-[8px] font-bold tracking-widest uppercase text-white/90">Verified</span>
            </div>
            
            <!-- Instructor Signature -->
            <div class="text-right">
              <div class="font-['Allura',cursive] text-4xl text-on-surface/80 border-b border-surface-container-high pb-1 mb-2 px-4 inline-block min-w-37.5 text-center">
                M. Chen
              </div>
              <p class="text-xs text-secondary uppercase tracking-wider">Marcus Chen</p>
              <p class="text-[10px] text-secondary mt-1">Lead Instructor, NexLearn</p>
            </div>
            
          </div>
          
        </div>
      </div>
    </div>
    
  </div>
</template>

<script setup>
// Certificate logic here
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Allura&family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');
</style>

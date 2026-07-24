<template>
  <div class="relative w-full h-full bg-black rounded-2xl overflow-hidden shadow-2xl group flex flex-col">
    <!-- Video Poster / Placeholder -->
    <div class="relative w-full h-full bg-slate-900 flex items-center justify-center overflow-hidden">
      <img
        class="w-full h-full object-cover transition-all duration-700"
        :class="isPlaying ? 'opacity-50 scale-[1.02]' : 'opacity-75'"
        :alt="posterAlt"
        :src="posterUrl"
      />

      <!-- Ambient Glow saat Playing -->
      <div v-if="isPlaying" class="absolute inset-0 bg-linear-to-tr from-primary/15 to-transparent mix-blend-overlay pointer-events-none"></div>

      <!-- Tombol Play Besar -->
      <transition
        enter-active-class="transition duration-300"
        enter-from-class="opacity-0 scale-75"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition duration-200"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-75"
      >
        <button
          v-if="!isPlaying"
          @click="togglePlay"
          class="absolute w-24 h-24 bg-white/10 backdrop-blur-md border border-white/30 rounded-full flex items-center justify-center text-white hover:bg-white/25 transition-all shadow-[0_0_40px_rgba(255,255,255,0.1)] hover:shadow-[0_0_70px_rgba(255,255,255,0.25)] hover:scale-110 z-10"
        >
          <span class="material-symbols-outlined text-6xl" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
        </button>
      </transition>

      <!-- Popup Quiz Overlay (via slot / component) -->
      <slot name="quiz" />
    </div>

    <!-- Control Bar Bawah -->
    <div
      class="absolute bottom-0 left-0 right-0 p-4 pt-12 bg-linear-to-t from-black/90 via-black/50 to-transparent flex items-center gap-3 transition-all duration-300 z-10"
      :class="isPlaying ? 'opacity-0 hover:opacity-100' : 'opacity-100'"
    >
      <!-- Play/Pause -->
      <button @click="togglePlay" class="text-white hover:text-primary transition-colors hover:scale-110 transform shrink-0">
        <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">
          {{ isPlaying ? 'pause_circle' : 'play_circle' }}
        </span>
      </button>

      <!-- Progress Bar -->
      <div
        class="flex-1 h-1.5 bg-white/20 rounded-full relative cursor-pointer group/progress"
        @click="seek"
      >
        <!-- Buffer -->
        <div class="absolute inset-y-0 left-0 rounded-full bg-white/15" :style="{ width: bufferPercent + '%' }"></div>
        <!-- Progress -->
        <div class="absolute inset-y-0 left-0 rounded-full bg-primary" :style="{ width: progressPercent + '%' }">
          <div class="absolute right-0 top-1/2 -translate-y-1/2 w-3.5 h-3.5 bg-white rounded-full shadow opacity-0 group-hover/progress:opacity-100 transition-opacity scale-0 group-hover/progress:scale-100"></div>
        </div>
      </div>

      <!-- Timestamp -->
      <span class="text-white/90 text-xs font-mono shrink-0">{{ formatTime(currentTime) }} / {{ formatTime(duration) }}</span>

      <!-- Kontrol Akhir -->
      <div class="flex items-center gap-2 ml-1 shrink-0">
        <button @click="toggleMute" class="text-white hover:text-primary transition-colors">
          <span class="material-symbols-outlined text-[20px]">{{ isMuted ? 'volume_off' : 'volume_up' }}</span>
        </button>
        <button class="text-white hover:text-primary transition-colors">
          <span class="material-symbols-outlined text-[20px]">closed_caption</span>
        </button>
        <button class="text-white hover:text-primary transition-colors">
          <span class="material-symbols-outlined text-[20px]">settings</span>
        </button>
        <button class="text-white hover:text-primary transition-colors">
          <span class="material-symbols-outlined text-[20px]">fullscreen</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  posterUrl: {
    type: String,
    default: 'https://lh3.googleusercontent.com/aida-public/AB6AXuA0RP7kGuFLvE-MxKRPkETJKsTdJcVtU8iCWwmR_gXzkACXq1teovWWTaxh87vuAtcn7puOCd-2ett9fPQfeo96PAttoGCI9NIMsLgLjHJno2z1ykyzHo9zXyzQFwwt8gI3XOV4GS9m-rydsbcvYFPzxN3TEFMbhMd1wqch1MmEKD_gyFk1I5zBd4m4lBHlqD3tYVbTUVlHwQTZkbXie8KRdeA4DkZ9yACbbsPyIbVh_CPmD-iG4vyiQbxK85-ymcxFGloNTAeXlDyK'
  },
  posterAlt: { type: String, default: 'Video Thumbnail' }
});

const emit = defineEmits(['play', 'pause', 'seek']);

const isPlaying = ref(false);
const isMuted = ref(false);
const currentTime = ref(522); // 8:42 untuk demo
const duration = ref(1455);  // 24:15 untuk demo
const progressPercent = ref(35);
const bufferPercent = ref(60);

const togglePlay = () => {
  isPlaying.value = !isPlaying.value;
  emit(isPlaying.value ? 'play' : 'pause');
};

const toggleMute = () => {
  isMuted.value = !isMuted.value;
};

const seek = (e) => {
  const rect = e.currentTarget.getBoundingClientRect();
  const pct = Math.min(Math.max(((e.clientX - rect.left) / rect.width) * 100, 0), 100);
  progressPercent.value = pct;
  currentTime.value = Math.round((pct / 100) * duration.value);
  emit('seek', currentTime.value);
};

const formatTime = (seconds) => {
  const m = Math.floor(seconds / 60);
  const s = seconds % 60;
  return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
};
</script>

<template>
  <div ref="playerContainer" class="relative w-full h-full bg-black rounded-2xl overflow-hidden shadow-2xl group flex flex-col">
    <!-- Video Poster / Placeholder -->
    <div class="relative w-full h-full bg-slate-900 flex items-center justify-center overflow-hidden">
      <!-- Video Element -->
      <video
        ref="videoRef"
        class="w-full h-full object-cover transition-all duration-700"
        :class="isPlaying ? 'scale-[1.02]' : 'opacity-75'"
        :src="src"
        :poster="posterUrl"
        @timeupdate="onTimeUpdate"
        @loadedmetadata="onLoadedMetadata"
        @ended="onEnded"
        @click="togglePlay"
      ></video>

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
      
      <!-- Settings Menu (Speed) -->
      <transition enter-active-class="transition duration-200" enter-from-class="opacity-0 translate-y-2" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-2">
        <div v-if="showSettings" class="absolute bottom-16 right-4 bg-surface-container-highest text-on-surface p-2 rounded-xl shadow-xl flex flex-col gap-1 z-20 w-32 border border-surface-container-low">
          <div class="text-[10px] font-bold text-secondary uppercase px-2 py-1">Kecepatan</div>
          <button v-for="rate in playbackRates" :key="rate" @click="setPlaybackRate(rate)" class="text-xs font-medium px-2 py-1.5 rounded-lg text-left hover:bg-primary/10 hover:text-primary transition-colors flex justify-between items-center" :class="currentRate === rate ? 'bg-primary/10 text-primary' : ''">
            {{ rate }}x
            <span v-if="currentRate === rate" class="material-symbols-outlined text-[14px]">check</span>
          </button>
        </div>
      </transition>
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
        <button @click="toggleCC" class="text-white hover:text-primary transition-colors" title="Subtitles / CC">
          <span class="material-symbols-outlined text-[20px]">closed_caption</span>
        </button>
        <button @click="showSettings = !showSettings" class="text-white hover:text-primary transition-colors" title="Pengaturan">
          <span class="material-symbols-outlined text-[20px]">settings</span>
        </button>
        <button @click="toggleFullscreen" class="text-white hover:text-primary transition-colors" title="Layar Penuh">
          <span class="material-symbols-outlined text-[20px]">{{ isFullscreen ? 'fullscreen_exit' : 'fullscreen' }}</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({
  src: { type: String, default: '' },
  posterUrl: {
    type: String,
    default: 'https://lh3.googleusercontent.com/aida-public/AB6AXuA0RP7kGuFLvE-MxKRPkETJKsTdJcVtU8iCWwmR_gXzkACXq1teovWWTaxh87vuAtcn7puOCd-2ett9fPQfeo96PAttoGCI9NIMsLgLjHJno2z1ykyzHo9zXyzQFwwt8gI3XOV4GS9m-rydsbcvYFPzxN3TEFMbhMd1wqch1MmEKD_gyFk1I5zBd4m4lBHlqD3tYVbTUVlHwQTZkbXie8KRdeA4DkZ9yACbbsPyIbVh_CPmD-iG4vyiQbxK85-ymcxFGloNTAeXlDyK'
  },
  posterAlt: { type: String, default: 'Video Thumbnail' }
});

const emit = defineEmits(['play', 'pause', 'seek', 'timeupdate', 'ended']);

const videoRef = ref(null);
const playerContainer = ref(null);
const isPlaying = ref(false);
const isMuted = ref(false);
const currentTime = ref(0);
const duration = ref(0);
const progressPercent = ref(0);
const bufferPercent = ref(100);
const isFullscreen = ref(false);

const showSettings = ref(false);
const playbackRates = [0.5, 0.75, 1, 1.25, 1.5, 2];
const currentRate = ref(1);

// Reset ketika src berubah
watch(() => props.src, () => {
  isPlaying.value = false;
  currentTime.value = 0;
  progressPercent.value = 0;
  if (videoRef.value) {
    videoRef.value.load();
  }
});

const togglePlay = () => {
  if (!videoRef.value) return;
  
  if (isPlaying.value) {
    videoRef.value.pause();
    isPlaying.value = false;
    emit('pause');
  } else {
    videoRef.value.play();
    isPlaying.value = true;
    emit('play');
  }
};

const toggleMute = () => {
  if (!videoRef.value) return;
  isMuted.value = !isMuted.value;
  videoRef.value.muted = isMuted.value;
};

const seek = (e) => {
  if (!videoRef.value) return;
  const rect = e.currentTarget.getBoundingClientRect();
  const pct = Math.min(Math.max(((e.clientX - rect.left) / rect.width), 0), 1);
  videoRef.value.currentTime = pct * duration.value;
};

const onTimeUpdate = () => {
  if (!videoRef.value) return;
  currentTime.value = videoRef.value.currentTime;
  if (duration.value > 0) {
    progressPercent.value = (currentTime.value / duration.value) * 100;
  }
  emit('timeupdate', currentTime.value);
};

const onLoadedMetadata = () => {
  if (!videoRef.value) return;
  duration.value = videoRef.value.duration;
};

const onEnded = () => {
  isPlaying.value = false;
  emit('pause');
  emit('ended');
};

const formatTime = (seconds) => {
  if (isNaN(seconds)) return '00:00';
  const m = Math.floor(seconds / 60);
  const s = Math.floor(seconds % 60);
  return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
};

const toggleFullscreen = () => {
  if (!document.fullscreenElement) {
    playerContainer.value?.requestFullscreen().catch(err => {
      console.error(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
    });
  } else {
    document.exitFullscreen();
  }
};

const setPlaybackRate = (rate) => {
  currentRate.value = rate;
  if (videoRef.value) {
    videoRef.value.playbackRate = rate;
  }
  showSettings.value = false;
};

const toggleCC = () => {
  // Mockup untuk fitur CC
  Swal.fire({
    title: 'Info Subtitle',
    text: 'Subtitle/CC belum tersedia untuk materi video ini.',
    icon: 'info',
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000
  });
};

onMounted(() => {
  document.addEventListener('fullscreenchange', () => {
    isFullscreen.value = !!document.fullscreenElement;
  });
});
</script>

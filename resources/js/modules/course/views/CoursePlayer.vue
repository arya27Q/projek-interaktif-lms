<template>
  <div class="lg:h-[calc(100vh-140px)] flex flex-col lg:flex-row gap-4 md:gap-6 w-full lg:overflow-x-auto lg:snap-x lg:snap-mandatory pb-2 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] scrollbar-none">
    
    <!-- ════════════════════════════════════════
         Kolom Kiri: Video Player (70%)
    ════════════════════════════════════════ -->
    <section class="w-full lg:min-w-full shrink-0 lg:snap-center h-full flex flex-col gap-4">
      
      <!-- Player Container -->
      <div class="relative flex-1 min-h-0">
        <VideoPlayer
          :src="store.currentLesson?.media_url"
          :poster-url="posterUrl"
          poster-alt="Thumbnail Video Kursus"
          @play="store.play()"
          @pause="store.pause()"
          @timeupdate="onTimeUpdate"
          @ended="onEnded"
        >
          <!-- Slot Quiz Pop-up -->
          <template #quiz>
            <PopupQuiz
              v-model="store.showQuiz"
              :quiz="store.currentQuiz || defaultQuiz"
              @answered="onQuizAnswered"
            />
          </template>
        </VideoPlayer>
      </div>

      <!-- Info Video -->
      <div class="bg-surface-container-lowest p-5 md:p-6 rounded-2xl shadow-sm border border-surface-container-low flex flex-col sm:flex-row sm:items-center justify-between gap-4 shrink-0">
        <div>
          <h2 class="font-headline-md text-lg md:text-xl font-bold text-on-surface mb-1">
            {{ store.currentLesson?.title || 'Memuat pelajaran...' }}
          </h2>
          <div class="flex flex-wrap items-center gap-2 text-secondary text-sm">
            <span class="px-2 py-0.5 bg-primary/10 text-primary rounded text-xs font-bold uppercase tracking-wider whitespace-nowrap">
              {{ store.currentCourse?.title || 'Memuat Kursus...' }}
            </span>
            <span class="hidden sm:inline">Pelajaran ini bagian dari kursus tersebut.</span>
          </div>
        </div>
        <div class="flex items-center gap-2 shrink-0 flex-wrap">
          <button @click="store.triggerQuiz(defaultQuiz)" class="flex items-center gap-1.5 px-4 py-2 border border-outline-variant rounded-full text-sm font-medium hover:bg-surface-container-low hover:text-primary transition-all">
            <span class="material-symbols-outlined text-base">quiz</span> Kuis
          </button>
          <button @click="store.toggleBookmark()" class="flex items-center gap-1.5 px-4 py-2 border rounded-full text-sm font-medium transition-all"
            :class="store.isBookmarked ? 'bg-primary/10 text-primary border-primary' : 'border-outline-variant hover:bg-surface-container-low hover:text-primary'">
            <span class="material-symbols-outlined text-base">{{ store.isBookmarked ? 'bookmark_added' : 'bookmark' }}</span> 
            {{ store.isBookmarked ? 'Tersimpan' : 'Simpan' }}
          </button>
          <button @click="downloadMateri" class="flex items-center gap-1.5 px-5 py-2 bg-on-surface text-surface rounded-full text-sm font-bold hover:shadow-lg transition-all hover:-translate-y-0.5 active:scale-95">
            <span class="material-symbols-outlined text-base">download</span> Materi
          </button>
        </div>
      </div>
    </section>

    <!-- ════════════════════════════════════════
         Kolom Kanan: Sidebar (30%)
    ════════════════════════════════════════ -->
    <section class="w-full lg:w-112.5 lg:min-w-112.5 shrink-0 lg:snap-center h-175 lg:h-full flex flex-col bg-surface-container-lowest rounded-2xl shadow-sm border border-surface-container-low overflow-hidden">
      
      <!-- Tab Header -->
      <div class="flex border-b border-surface-container-low shrink-0 bg-surface-container-lowest z-10">
        <button
          v-for="tab in tabs" :key="tab.id"
          @click="store.activeTab = tab.id"
          class="flex-1 py-4 text-[11px] font-bold tracking-wider uppercase transition-all relative overflow-hidden"
          :class="store.activeTab === tab.id ? 'text-primary' : 'text-secondary hover:text-on-surface hover:bg-surface-container-low'"
        >
          {{ tab.name }}
          <div v-if="store.activeTab === tab.id" class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary rounded-t-full shadow-[0_-2px_10px_rgba(0,88,190,0.5)]"></div>
        </button>
      </div>

      <!-- ── Tab: Daftar Materi ─────────────── -->
      <div v-show="store.activeTab === 'content'" class="flex-1 overflow-y-auto px-4 py-2 custom-scrollbar">
        <div class="space-y-1">
          <template v-for="mod in store.modules" :key="mod.id">
            <!-- Judul Modul -->
            <div class="pt-5 pb-2 sticky top-0 bg-surface-container-lowest z-10 flex items-center justify-between">
              <h5 class="text-[11px] font-bold text-secondary uppercase tracking-wider flex items-center gap-2">
                <span class="w-4 h-0.5 bg-secondary/30 rounded-full"></span>
                {{ mod.title }}
              </h5>
              <div v-if="mod.isBypassed" class="flex items-center gap-1 bg-tertiary/10 text-tertiary px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-widest" title="Materi ini dilewati karena skor Pre-test > 90">
                <span class="material-symbols-outlined text-[12px]">fast_forward</span> Bypass
              </div>
              <div v-else-if="mod.isRemedial" class="flex items-center gap-1 bg-error/10 text-error px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-widest" title="Materi tambahan karena skor Kuis < 60">
                <span class="material-symbols-outlined text-[12px]">health_and_safety</span> Remedial
              </div>
            </div>

            <!-- Pelajaran -->
            <div
              v-for="lesson in mod.lessons" :key="lesson.id"
              @click="!lesson.locked && store.selectLesson(lesson.id)"
              class="group flex items-center gap-3 p-3 rounded-xl transition-all"
              :class="[
                lesson.isActive ? 'bg-primary text-on-primary shadow-lg shadow-primary/20 scale-[1.02]' : '',
                lesson.locked ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
                !lesson.isActive && !lesson.locked ? 'border border-transparent hover:border-outline-variant hover:bg-surface-container-low' : ''
              ]"
            >
              <!-- Nomor / Ikon -->
              <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold shrink-0 transition-colors"
                :class="[
                  lesson.isActive ? 'bg-white/20 text-white' : '',
                  lesson.completed ? 'bg-primary/10 text-primary' : '',
                  !lesson.isActive && !lesson.completed ? 'bg-surface-container-high text-secondary group-hover:bg-surface-container-high' : ''
                ]">
                <span v-if="lesson.completed && !lesson.isActive" class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <span v-else-if="lesson.locked" class="material-symbols-outlined text-[18px]">lock</span>
                <span v-else>{{ lesson.id.toString().padStart(2, '0') }}</span>
              </div>

              <!-- Judul & Durasi -->
              <div class="flex-1 min-w-0">
                <p class="text-sm font-bold truncate transition-colors"
                  :class="lesson.isActive ? 'text-white' : 'text-on-surface group-hover:text-primary'">
                  {{ lesson.title }}
                </p>
                <p class="text-[11px] flex items-center gap-1 mt-0.5"
                  :class="lesson.isActive ? 'text-white/70' : 'text-secondary'">
                  <span v-if="lesson.isActive" class="w-1.5 h-1.5 rounded-full bg-error animate-pulse shrink-0"></span>
                  <span class="material-symbols-outlined text-[12px]" v-else>schedule</span>
                  {{ lesson.isActive ? 'Sedang Diputar' : lesson.duration }}
                </p>
              </div>
            </div>
          </template>
        </div>
      </div>

      <!-- ── Tab: Catatan ───────────────────── -->
      <div v-show="store.activeTab === 'notes'" class="flex-1 overflow-y-auto px-5 py-4 custom-scrollbar space-y-5">
        <!-- Form Tambah Catatan -->
        <div v-if="isWritingNote" class="bg-surface-container-lowest border border-primary p-4 rounded-xl shadow-lg relative animate-in fade-in slide-in-from-top-2">
          <div class="flex items-center gap-2 text-xs font-bold text-primary mb-3">
            <span class="material-symbols-outlined text-[16px]">timer</span>
            Menyimpan catatan pada {{ store.formatTime(store.currentTime) }}
          </div>
          <textarea v-model="newNoteText" class="w-full bg-surface-container-low border border-transparent rounded-lg p-3 text-sm focus:border-primary focus:bg-surface-container-lowest focus:ring-4 focus:ring-primary/10 outline-none resize-none transition-all" rows="3" placeholder="Ketik catatanmu di sini..."></textarea>
          <div class="flex justify-end gap-2 mt-3">
            <button @click="isWritingNote = false" class="px-4 py-2 text-xs font-bold text-secondary hover:text-on-surface transition-colors">Batal</button>
            <button @click="saveNote" class="px-4 py-2 text-xs font-bold bg-primary text-white rounded-lg hover:shadow-md transition-all active:scale-95 flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[14px]">save</span> Simpan
            </button>
          </div>
        </div>
        
        <!-- Tombol Tambah Catatan -->
        <button v-else @click="startWritingNote" class="w-full p-4 border-2 border-dashed border-outline-variant rounded-xl text-secondary text-sm font-medium hover:border-primary hover:text-primary hover:bg-primary/5 transition-all flex flex-col items-center gap-2 group">
          <div class="w-9 h-9 rounded-full bg-surface-container-high group-hover:bg-primary/10 flex items-center justify-center transition-colors">
            <span class="material-symbols-outlined">edit_note</span>
          </div>
          Tambah catatan di <span class="bg-surface-container-low px-2 py-0.5 rounded text-xs font-mono group-hover:bg-primary/10">{{ store.formatTime(store.currentTime) }}</span>
        </button>

        <!-- Daftar catatan -->
        <div class="space-y-4">
          <div
            v-for="note in store.notes" :key="note.id"
            class="p-4 bg-surface-container-lowest border border-surface-container-low shadow-sm rounded-xl border-l-4 hover:shadow-md transition-shadow"
            :class="note.id % 2 === 0 ? 'border-l-tertiary' : 'border-l-primary'"
          >
            <div class="flex justify-between items-center mb-3">
              <span class="text-xs font-bold px-2 py-1 rounded-md flex items-center gap-1"
                :class="note.id % 2 === 0 ? 'text-tertiary bg-tertiary/10' : 'text-primary bg-primary/10'">
                <span class="material-symbols-outlined text-[14px]">play_circle</span>
                {{ store.formatTime(note.timestamp) }}
              </span>
              <div class="flex items-center gap-2">
                <span class="text-[10px] text-secondary font-medium">{{ note.createdAt }}</span>
                <button class="text-secondary hover:text-error transition-colors">
                  <span class="material-symbols-outlined text-[16px]">more_vert</span>
                </button>
              </div>
            </div>
            <p class="text-sm text-on-surface leading-relaxed">{{ note.text }}</p>
          </div>
        </div>
      </div>

      <!-- ── Tab: Diskusi / Q&A ─────────────── -->
      <div v-show="store.activeTab === 'qa'" class="flex-1 flex flex-col overflow-hidden">
        <!-- Header Diskusi -->
        <div class="p-4 border-b border-surface-container-low shrink-0 bg-surface-container-lowest z-10 shadow-sm relative">
          <div v-if="isAskingQuestion" class="mb-4 animate-in fade-in slide-in-from-top-2">
            <div class="flex justify-between items-center mb-2">
              <span class="text-xs font-bold text-primary flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">link</span> Terkait video: {{ store.formatTime(store.currentTime) }}
              </span>
              <button @click="isAskingQuestion = false" class="text-secondary hover:text-error transition-colors">
                <span class="material-symbols-outlined text-[18px]">close</span>
              </button>
            </div>
            <textarea v-model="newQuestionText" class="w-full bg-surface-container-low border border-transparent rounded-lg p-3 text-sm focus:border-primary focus:bg-surface-container-lowest focus:ring-4 focus:ring-primary/10 outline-none resize-none transition-all mb-2" rows="3" placeholder="Tulis pertanyaanmu secara spesifik..."></textarea>
            <button @click="submitQuestion" class="w-full py-2.5 bg-primary text-white rounded-lg text-sm font-bold hover:shadow-md transition-all active:scale-95 flex justify-center items-center gap-2">
              Kirim Pertanyaan <span class="material-symbols-outlined text-[16px]">send</span>
            </button>
          </div>
          
          <button v-else @click="startAskingQuestion" class="w-full py-3 bg-on-surface text-surface-container-lowest rounded-xl text-sm font-bold hover:shadow-lg hover:-translate-y-0.5 transition-all mb-4 active:scale-95 flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-[18px]">chat_add_on</span> Ajukan Pertanyaan
          </button>
          
          <div class="relative group">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-secondary text-sm group-focus-within:text-primary transition-colors">search</span>
            <input class="w-full bg-surface-container-low border border-transparent rounded-full py-2.5 pl-9 pr-4 text-xs focus:bg-surface-container-lowest focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none" placeholder="Cari diskusi..." type="text"/>
          </div>
        </div>

        <!-- Daftar Pertanyaan -->
        <div class="flex-1 overflow-y-auto custom-scrollbar divide-y divide-surface-container-low">
          <div
            v-for="disc in store.discussions" :key="disc.id"
            class="p-5 hover:bg-surface-container-low/50 transition-colors cursor-pointer group"
          >
            <div class="flex gap-3 mb-2">
              <div class="w-8 h-8 rounded-full shrink-0 overflow-hidden border border-surface-container-low shadow-sm">
                <img class="w-full h-full object-cover" :alt="disc.author" :src="disc.avatar"/>
              </div>
              <div class="flex-1">
                <p class="text-xs font-bold text-on-surface flex items-center justify-between">
                  {{ disc.author }}
                  <span class="flex flex-wrap items-center gap-2">
                    <span class="text-[9px] px-1.5 py-0.5 bg-primary/10 text-primary rounded font-mono font-bold flex items-center gap-0.5 whitespace-nowrap"><span class="material-symbols-outlined text-[10px]">play_circle</span> {{ store.formatTime(disc.videoTimestamp || store.currentTime) }}</span>
                    <span class="text-[10px] text-secondary font-normal whitespace-nowrap">{{ disc.createdAt }}</span>
                  </span>
                </p>
                <p class="text-sm text-on-surface leading-snug mt-1 group-hover:text-primary transition-colors">{{ disc.question }}</p>
              </div>
            </div>
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-[11px] font-bold pl-11 mt-3">
              <span class="flex items-center gap-1 text-secondary hover:text-primary transition-colors px-2 py-1 rounded-full bg-surface-container-low whitespace-nowrap cursor-pointer">
                <span class="material-symbols-outlined text-[14px]">thumb_up</span> {{ disc.likes }}
              </span>
              <span class="flex items-center gap-1 text-secondary hover:text-primary transition-colors px-2 py-1 rounded-full bg-surface-container-low whitespace-nowrap cursor-pointer">
                <span class="material-symbols-outlined text-[14px]">chat_bubble</span> {{ disc.replies }} balasan
              </span>
              <span v-if="disc.isSolved" class="flex items-center gap-1 text-primary bg-primary/10 px-2 py-1 rounded-full whitespace-nowrap">
                <span class="material-symbols-outlined text-[14px]">check_circle</span> Terjawab
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer Progress -->
      <div class="p-5 bg-surface-container-lowest border-t border-surface-container-low shrink-0 relative z-10">
        <div class="flex flex-wrap items-center justify-between gap-2 text-[11px] tracking-wide text-secondary mb-3">
          <span class="font-bold flex items-center gap-1 whitespace-nowrap">
            <span class="material-symbols-outlined text-[14px]">analytics</span> PROGRES
          </span>
          <span class="font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full whitespace-nowrap">
            {{ store.progressPercent }}% • {{ store.completedLessons }}/{{ store.totalLessons }} PELAJARAN
          </span>
        </div>
        <div class="w-full h-2.5 bg-surface-container-high rounded-full overflow-hidden shadow-inner relative">
          <div
            class="absolute inset-y-0 left-0 bg-primary rounded-full transition-all duration-1000 ease-out flex items-center justify-end pr-1"
            :style="{ width: store.progressPercent + '%' }"
          >
            <div class="w-1.5 h-1.5 bg-white rounded-full opacity-80"></div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useCoursePlayerStore } from '../../course-player/store/coursePlayerStore.js';
import VideoPlayer from '../../../modules/course-player/components/VideoPlayer.vue';
import PopupQuiz from '../../../modules/course-player/components/PopupQuiz.vue';

const store = useCoursePlayerStore();
const route = useRoute();

onMounted(() => {
  const courseId = route.params.id;
  if (courseId) {
    store.fetchCourseData(courseId);
  }
});

// UI States
const isWritingNote = ref(false);
const newNoteText = ref('');
const isAskingQuestion = ref(false);
const newQuestionText = ref('');

// Actions
const startWritingNote = () => {
  store.pause(); // Pause video while typing note
  isWritingNote.value = true;
};

const saveNote = () => {
  if (newNoteText.value.trim()) {
    store.notes.unshift({
      id: Date.now(),
      timestamp: store.currentTime,
      text: newNoteText.value,
      createdAt: 'Baru saja'
    });
    newNoteText.value = '';
    isWritingNote.value = false;
  }
};

const startAskingQuestion = () => {
  store.pause();
  isAskingQuestion.value = true;
};

const submitQuestion = () => {
  if (newQuestionText.value.trim() === '') return;
  store.postDiscussion(newQuestionText.value);
  newQuestionText.value = '';
  isAskingQuestion.value = false;
};

let lastSyncTime = 0;
const onTimeUpdate = (time) => {
  store.currentTime = time;
  // Sync progress every 10 seconds to avoid spamming the server
  if (time - lastSyncTime >= 10) {
    store.syncProgress(time, false);
    lastSyncTime = time;
  }
};

const onEnded = () => {
  store.syncProgress(store.currentTime, true);
};

const downloadMateri = () => {
  const url = store.currentLesson?.media_url;
  if (url) {
    window.open(url, '_blank');
  } else {
    Swal.fire('Info', 'Tidak ada file materi untuk di-download pada pelajaran ini.', 'info');
  }
};

const tabs = [
  { id: 'content', name: 'Materi' },
  { id: 'notes', name: 'Catatan' },
  { id: 'qa', name: 'Diskusi' }
];

const posterUrl = 'https://lh3.googleusercontent.com/aida-public/AB6AXuA0RP7kGuFLvE-MxKRPkETJKsTdJcVtU8iCWwmR_gXzkACXq1teovWWTaxh87vuAtcn7puOCd-2ett9fPQfeo96PAttoGCI9NIMsLgLjHJno2z1ykyzHo9zXyzQFwwt8gI3XOV4GS9m-rydsbcvYFPzxN3TEFMbhMd1wqch1MmEKD_gyFk1I5zBd4m4lBHlqD3tYVbTUVlHwQTZkbXie8KRdeA4DkZ9yACbbsPyIbVh_CPmD-iG4vyiQbxK85-ymcxFGloNTAeXlDyK';

const defaultQuiz = {
  question: 'Berdasarkan diagram arsitektur yang baru saja ditampilkan, di mana sebaiknya logika state-machine utama ditempatkan?',
  options: [
    'Di dalam komponen halaman individual',
    'Di dalam Shell Layout sebagai state global',
    'Di komponen atom yang paling kecil',
    'Langsung di file router aplikasi'
  ],
  correctIndex: 1,
  explanation: 'Shell Logic ditempatkan di level layout utama agar bisa diakses dan dikelola secara terpusat oleh semua halaman turunannya, menjaga konsistensi navigasi antar halaman.'
};

const onQuizAnswered = ({ correct }) => {
  if (correct) {
    // Beri EXP jika ada gamificationStore yang diimport
    console.log('Jawaban benar! +10 EXP');
  }
};
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 5px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: var(--color-surface-variant, #e1e3e4); border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: var(--color-outline, #727785); }
</style>

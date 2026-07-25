<template>
  <Teleport to="body">
    <transition
      enter-active-class="transition duration-400 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-300 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="modelValue"
        class="fixed inset-0 z-100 flex items-center justify-center bg-black/65 backdrop-blur-[2px] p-4"
      >
      <!-- Kartu Quiz -->
      <transition
        enter-active-class="transition duration-400 ease-out"
        enter-from-class="opacity-0 translate-y-8 scale-95"
        enter-to-class="opacity-100 translate-y-0 scale-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0 translate-y-4"
      >
        <!-- Panel Pertanyaan -->
        <div v-if="!isAnswered" class="w-full max-w-md bg-surface-container-lowest rounded-2xl shadow-2xl ring-1 ring-black/10 overflow-hidden">
          <!-- Header biru -->
          <div class="bg-primary px-5 py-3.5 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
              <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-white text-[16px]" style="font-variation-settings: 'FILL' 1;">quiz</span>
              </div>
              <div>
                <h4 class="font-bold text-white text-sm leading-tight">Kuis Singkat</h4>
                <p class="text-white/70 text-[11px]">Video dijeda — jawab dulu!</p>
              </div>
            </div>
            <!-- Timer -->
            <div class="flex items-center gap-1.5 bg-white/15 px-3 py-1 rounded-full shrink-0">
              <span class="material-symbols-outlined text-white text-[14px]">timer</span>
              <span class="text-white font-bold text-sm font-mono leading-none">{{ timeLeft }}s</span>
            </div>
          </div>

          <!-- Body -->
          <div class="p-5">
            <p class="text-on-surface font-medium text-sm leading-relaxed mb-4">{{ quiz.question }}</p>

            <!-- Pilihan jawaban -->
            <div class="space-y-2 mb-5">
              <button
                v-for="(option, idx) in quiz.options"
                :key="idx"
                @click="selectOption(idx)"
                class="w-full text-left px-4 py-3 rounded-xl border text-sm font-medium transition-all duration-200 flex items-center gap-3"
                :class="selectedOption === idx
                  ? 'border-primary bg-primary/10 text-primary shadow-sm'
                  : 'border-outline-variant text-secondary hover:border-primary/40 hover:bg-surface-container-low hover:text-on-surface'"
              >
                <span
                  class="w-6 h-6 rounded-full border-2 flex items-center justify-center shrink-0 text-[11px] font-bold transition-all"
                  :class="selectedOption === idx
                    ? 'border-primary bg-primary text-white'
                    : 'border-outline-variant text-secondary'"
                >
                  <span class="material-symbols-outlined text-[13px]" v-if="selectedOption === idx">check</span>
                  <span v-else>{{ String.fromCharCode(65 + idx) }}</span>
                </span>
                {{ option }}
              </button>
            </div>

            <!-- Tombol kirim -->
            <button
              @click="submitAnswer"
              :disabled="selectedOption === null"
              class="w-full py-3 bg-primary text-white rounded-xl font-bold text-sm transition-all hover:-translate-y-0.5 active:scale-95 shadow-md disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:translate-y-0"
            >
              Kirim Jawaban
            </button>
          </div>
        </div>

        <!-- Panel Hasil -->
        <div
          v-else
          class="w-full max-w-xs bg-surface-container-lowest rounded-2xl shadow-2xl ring-1 text-center overflow-hidden"
          :class="isCorrect ? 'ring-green-200' : 'ring-red-200'"
        >
          <!-- Bar warna atas -->
          <div class="h-2 w-full" :class="isCorrect ? 'bg-green-500' : 'bg-error'"></div>
          <div class="p-6">
            <div
              class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center"
              :class="isCorrect ? 'bg-green-50' : 'bg-red-50'"
            >
              <span
                class="material-symbols-outlined text-5xl"
                :class="isCorrect ? 'text-green-500' : 'text-error'"
                style="font-variation-settings: 'FILL' 1;"
              >{{ isCorrect ? 'check_circle' : 'cancel' }}</span>
            </div>
            <h3 class="font-bold text-lg text-on-surface mb-2">
              {{ isCorrect ? 'Luar Biasa! 🎉' : 'Belum Tepat' }}
            </h3>
            <p class="text-secondary text-xs leading-relaxed mb-1">{{ quiz.explanation }}</p>
            <p v-if="isCorrect" class="text-green-600 font-bold text-sm mt-2">+10 EXP diperoleh!</p>
            <button
              @click="continueVideo"
              class="mt-5 w-full py-2.5 bg-on-surface text-white rounded-xl font-bold text-sm hover:-translate-y-0.5 transition-all active:scale-95"
            >
              {{ isCorrect ? 'Lanjutkan Video ▶' : 'Coba Lagi' }}
            </button>
          </div>
        </div>
      </transition>
    </div>
    </transition>
  </Teleport>
</template>

<script setup>
import { ref, watch, onUnmounted } from 'vue';

const props = defineProps({
  modelValue: { type: Boolean, default: false },
  quiz: {
    type: Object,
    default: () => ({
      question: 'Berdasarkan konsep yang baru dibahas, apa yang dimaksud dengan "Shell Logic" dalam desain navigasi?',
      options: [
        'Logika yang mengatur tampilan visual komponen',
        'Aturan alur navigasi dan state management di level layout utama',
        'Proses kompilasi JavaScript di browser',
        'Metode pengambilan data dari server backend'
      ],
      correctIndex: 1,
      explanation: 'Shell Logic adalah pola desain di mana logika navigasi ditempatkan di komponen layout utama (shell), bukan di halaman individual.'
    })
  }
});

const emit = defineEmits(['update:modelValue', 'answered']);

const selectedOption = ref(null);
const isAnswered = ref(false);
const isCorrect = ref(false);
const timeLeft = ref(30);
let timer = null;

const startTimer = () => {
  stopTimer();
  timer = setInterval(() => {
    timeLeft.value--;
    if (timeLeft.value <= 0) {
      stopTimer();
      submitAnswer();
    }
  }, 1000);
};

const stopTimer = () => {
  if (timer) { clearInterval(timer); timer = null; }
};

const selectOption = (idx) => { selectedOption.value = idx; };

const submitAnswer = () => {
  stopTimer();
  if (selectedOption.value === null) selectedOption.value = 0; // auto-select on timeout
  isAnswered.value = true;
  isCorrect.value = selectedOption.value === props.quiz.correctIndex;
  emit('answered', { correct: isCorrect.value, selectedIndex: selectedOption.value });
};

const continueVideo = () => {
  if (!isCorrect.value) {
    selectedOption.value = null;
    isAnswered.value = false;
    timeLeft.value = 30;
    startTimer();
  } else {
    emit('update:modelValue', false);
  }
};

watch(() => props.modelValue, (val) => {
  if (val) {
    selectedOption.value = null;
    isAnswered.value = false;
    isCorrect.value = false;
    timeLeft.value = 30;
    startTimer();
  } else {
    stopTimer();
  }
}, { immediate: false });

onUnmounted(stopTimer);
</script>

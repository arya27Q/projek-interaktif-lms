import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useCoursePlayerStore = defineStore('coursePlayer', () => {
  // ── State ──────────────────────────────────────────────────────────
  const isPlaying = ref(false);
  const currentTime = ref(0);       // detik
  const duration = ref(0);          // detik
  const isMuted = ref(false);
  const volume = ref(100);

  // Quiz pop-up
  const showQuiz = ref(false);
  const currentQuiz = ref(null);

  // Tab sidebar (content / catatan / diskusi)
  const activeTab = ref('content');

  // Daftar modul & pelajaran
  const modules = ref([
    {
      id: 1,
      title: 'Modul 4: Kerangka Global',
      lessons: [
        { id: 1, title: 'Pengenalan Shell Logic', duration: '12:40', completed: true, locked: false },
        { id: 2, title: 'Sistem Interaksi Lanjutan', duration: '24:15', completed: false, locked: false, isActive: true },
        { id: 3, title: 'Mandat Shell Semantik', duration: '18:50', completed: false, locked: true },
      ]
    },
    {
      id: 2,
      title: 'Modul 5: Poles & Fidelitas',
      lessons: [
        { id: 4, title: 'Teori Micro-interaksi', duration: '32:10', completed: false, locked: true },
        { id: 5, title: 'Animasi & Desain Gerak', duration: '28:05', completed: false, locked: true },
      ]
    }
  ]);

  const currentLessonId = ref(2);

  // Catatan (timestamped notes)
  const notes = ref([
    { id: 1, timestamp: 195, text: 'Pastikan z-index sidebar floating selalu lebih tinggi dari modal overlay untuk menjaga hierarki "Island".', createdAt: '2 jam lalu' },
    { id: 2, timestamp: 340, text: 'Aturan definisi shadow: Level 1 untuk shell persisten, Level 2 untuk objek floating sementara.', createdAt: 'Kemarin' }
  ]);

  // Diskusi
  const discussions = ref([
    {
      id: 1,
      author: 'Marcus Chen',
      avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBKX-BSFhv4vkGiprHQjWaEFPJ1UNzQAJiqoQGq_y6SFVBlgNQzx5w2AyvrsNlO3tHlRZqKfNtxT369HeWawHvq78FBsJNqfJ1r8NpTHkLfjzuxOFlGlBJbqNJ0EyrZRIJTypP4oApzDFKQMXPEckv-FOHQcVXRZN9meoAjcJ38OaEXV1KHOV7vZPLwmI2ASo8_x-r-zeYaUxDWXeEOFOk7jksEOIY1cfeLLTygVdASW6r8JhT5dQMC3gszr6jWA5_VoUZBLaNjSz96',
      question: 'Kenapa menggunakan floating margins dibanding docked edges untuk sidebar?',
      likes: 12,
      replies: 3,
      createdAt: '4 jam lalu',
      isSolved: false
    },
    {
      id: 2,
      author: 'Sarah Jenkins',
      avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBhcWegoxKYCql6QxBDvExKf7tw69mUT3AnGtphVPgSsZL39CvfFxbZzu6pn3ydtNN7VisFW4OSllCa2ebS7CygH-YzFwVYJbgDFFoE_fCwcGjuUZDih0SWr9n4K_NnUGnbZoxZT8JMaVKBZA0HpsjT_tT_Auurtt9R40KqhPBQn8Zz-53aWUMSX7Wz2ylvWMQtDfzOgXU3fiNqfJ4igAK1T2VoQuWgrCaVuePKeYorUk66SSDtR_s88PAqYLVfpDIgIi1Cf_p5ZlYr',
      question: 'Kesulitan dengan responsive pivot di tampilan tablet.',
      likes: 8,
      replies: 1,
      createdAt: 'Kemarin',
      isSolved: true
    }
  ]);

  // Progress
  const totalLessons = ref(24);
  const completedLessons = ref(12);

  // ── Getters ────────────────────────────────────────────────────────
  const progressPercent = computed(() =>
    Math.round((completedLessons.value / totalLessons.value) * 100)
  );

  const currentLesson = computed(() => {
    for (const mod of modules.value) {
      const lesson = mod.lessons.find(l => l.id === currentLessonId.value);
      if (lesson) return lesson;
    }
    return null;
  });

  const formatTime = (seconds) => {
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
  };

  // ── Actions ───────────────────────────────────────────────────────
  const togglePlay = () => { isPlaying.value = !isPlaying.value; };
  const pause = () => { isPlaying.value = false; };
  const play = () => { isPlaying.value = true; };

  const triggerQuiz = (quiz) => {
    currentQuiz.value = quiz;
    showQuiz.value = true;
    pause();
  };

  const dismissQuiz = () => {
    showQuiz.value = false;
    play();
  };

  const addNote = (text) => {
    notes.value.unshift({
      id: Date.now(),
      timestamp: currentTime.value,
      text,
      createdAt: 'Baru saja'
    });
  };

  const selectLesson = (lessonId) => {
    currentLessonId.value = lessonId;
    isPlaying.value = false;
    currentTime.value = 0;
  };

  return {
    isPlaying, currentTime, duration, isMuted, volume,
    showQuiz, currentQuiz,
    activeTab,
    modules, currentLessonId, currentLesson,
    notes, discussions,
    totalLessons, completedLessons, progressPercent,
    formatTime,
    togglePlay, pause, play,
    triggerQuiz, dismissQuiz,
    addNote, selectLesson
  };
});

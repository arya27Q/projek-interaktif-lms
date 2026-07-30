import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

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
  const modules = ref([]);
  const currentCourse = ref(null);

  const currentLessonId = ref(null);

  // Catatan (timestamped notes)
  const notes = ref([]);

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
      videoTimestamp: 120,
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
      videoTimestamp: 450,
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

  const fetchCourseData = async (courseId) => {
    try {
      const response = await axios.get(`/player/course/${courseId}`);
      currentCourse.value = response.data.data;
      modules.value = currentCourse.value.modules;
      
      // Select first lesson by default if none selected
      if (!currentLessonId.value && modules.value.length > 0 && modules.value[0].lessons.length > 0) {
        selectLesson(modules.value[0].lessons[0].id);
      }
    } catch (error) {
      console.error('Error fetching course data', error);
    }
  };

  const fetchNotes = async (lessonId) => {
    try {
      const response = await axios.get(`/player/lesson/${lessonId}/notes`);
      notes.value = response.data.map(n => ({
        id: n.id,
        timestamp: n.video_timestamp,
        text: n.text,
        createdAt: new Date(n.created_at).toLocaleDateString()
      }));
    } catch (error) {
      console.error('Error fetching notes', error);
    }
  };

  const addNote = async (text) => {
    if (!currentLessonId.value) return;
    try {
      const response = await axios.post(`/player/lesson/${currentLessonId.value}/notes`, {
        text,
        video_timestamp: Math.floor(currentTime.value)
      });
      notes.value.unshift({
        id: response.data.data.id,
        timestamp: response.data.data.video_timestamp,
        text: response.data.data.text,
        createdAt: 'Baru saja'
      });
    } catch (error) {
      console.error('Error saving note', error);
    }
  };

  const selectLesson = (lessonId) => {
    currentLessonId.value = lessonId;
    isPlaying.value = false;
    currentTime.value = 0;
    fetchNotes(lessonId);
  };

  return {
    isPlaying, currentTime, duration, isMuted, volume,
    showQuiz, currentQuiz,
    activeTab,
    modules, currentLessonId, currentLesson, currentCourse,
    notes, discussions,
    totalLessons, completedLessons, progressPercent,
    formatTime,
    togglePlay, pause, play,
    triggerQuiz, dismissQuiz,
    fetchCourseData, fetchNotes,
    addNote, selectLesson
  };
});

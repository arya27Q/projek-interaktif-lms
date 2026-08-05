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
  const modulesData = ref([]);
  const currentCourse = ref(null);

  const currentLessonId = ref(null);

  // Catatan (timestamped notes)
  const notes = ref([]);

  // Diskusi
  const discussions = ref([]);

  // Bookmark status
  const isBookmarked = ref(false);
  const completedLessonsArray = ref([]);

  // Progress
  const totalLessons = computed(() => {
    return modulesData.value.reduce((acc, mod) => acc + (mod.lessons?.length || 0), 0);
  });
  const completedLessons = computed(() => completedLessonsArray.value.length);

  // ── Getters ────────────────────────────────────────────────────────
  const progressPercent = computed(() => {
    if (totalLessons.value === 0) return 0;
    return Math.round((completedLessons.value / totalLessons.value) * 100);
  });

  const modules = computed(() => {
    return modulesData.value.map(mod => ({
      ...mod,
      lessons: mod.lessons.map(lesson => ({
        ...lesson,
        isActive: lesson.id === currentLessonId.value,
        locked: false, // Sementara semua kebuka untuk testing
        completed: completedLessonsArray.value.includes(lesson.id)
      }))
    }));
  });

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
      modulesData.value = currentCourse.value.modules || [];
      
      // Select first lesson by default if none selected
      if (!currentLessonId.value && modulesData.value.length > 0 && modulesData.value[0].lessons.length > 0) {
        selectLesson(modulesData.value[0].lessons[0].id);
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
    fetchDiscussions(lessonId);
  };

  const syncProgress = async (time, isCompleted = false) => {
    if (!currentLessonId.value) return;
    try {
      await axios.post(`/player/lesson/${currentLessonId.value}/progress`, {
        progress_seconds: Math.floor(time),
        is_completed: isCompleted
      });
      if (isCompleted && !completedLessonsArray.value.includes(currentLessonId.value)) {
        completedLessonsArray.value.push(currentLessonId.value);
      }
    } catch (error) {
      console.error('Error syncing progress', error);
    }
  };

  const toggleBookmark = async () => {
    if (!currentLessonId.value) return;
    try {
      const res = await axios.post(`/player/lesson/${currentLessonId.value}/bookmark`, {
        timestamp: Math.floor(currentTime.value)
      });
      isBookmarked.value = res.data.bookmarked;
    } catch (error) {
      console.error('Error toggling bookmark', error);
    }
  };

  const fetchDiscussions = async (lessonId) => {
    try {
      const res = await axios.get(`/player/lesson/${lessonId}/discussions`);
      discussions.value = res.data.data.map(d => ({
        id: d.id,
        author: d.user.name,
        avatar: d.user.avatar || 'https://ui-avatars.com/api/?name=' + d.user.name,
        question: d.content,
        likes: 0,
        replies: 0,
        createdAt: new Date(d.created_at).toLocaleDateString(),
        isSolved: false
      }));
    } catch (error) {
      console.error('Error fetching discussions', error);
    }
  };

  const postDiscussion = async (content) => {
    if (!currentLessonId.value) return;
    try {
      const res = await axios.post(`/player/lesson/${currentLessonId.value}/discussions`, { content });
      discussions.value.unshift({
        id: res.data.data.id,
        author: res.data.data.user.name,
        avatar: res.data.data.user.avatar || 'https://ui-avatars.com/api/?name=' + res.data.data.user.name,
        question: res.data.data.content,
        likes: 0,
        replies: 0,
        createdAt: 'Baru saja',
        isSolved: false
      });
    } catch (error) {
      console.error('Error posting discussion', error);
    }
  };

  const submitQuizResult = async (score) => {
    if (!currentLessonId.value) return;
    try {
      await axios.post(`/player/lesson/${currentLessonId.value}/quiz`, { score });
      if (!completedLessonsArray.value.includes(currentLessonId.value)) {
        completedLessonsArray.value.push(currentLessonId.value);
      }
    } catch (error) {
      console.error('Error submitting quiz', error);
    }
  };

  return {
    isPlaying, currentTime, duration, isMuted, volume,
    showQuiz, currentQuiz,
    activeTab,
    modules, currentLessonId, currentLesson, currentCourse,
    notes, discussions, isBookmarked,
    totalLessons, completedLessons, progressPercent, completedLessonsArray,
    formatTime,
    togglePlay, pause, play,
    triggerQuiz, dismissQuiz,
    fetchCourseData, fetchNotes,
    addNote, selectLesson,
    syncProgress, toggleBookmark, fetchDiscussions, postDiscussion, submitQuizResult
  };
});

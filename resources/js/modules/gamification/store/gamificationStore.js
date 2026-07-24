import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useGamificationStore = defineStore('gamification', () => {
  // ── State ──────────────────────────────────────────────────────────
  const currentStreak = ref(12);
  const longestStreak = ref(21);
  const totalExp = ref(2450);
  const level = ref(12);
  const expToNextLevel = ref(3000);
  const rankTier = ref('Scholar');

  // Daftar badge yang sudah diraih
  const earnedBadges = ref([
    { id: 1, name: 'Pelajar Malam', icon: 'dark_mode', description: 'Selesaikan materi setelah jam 12 malam', color: 'bg-indigo-500', earnedAt: '3 hari lalu' },
    { id: 2, name: 'Streak 7 Hari', icon: 'local_fire_department', description: 'Belajar 7 hari berturut-turut', color: 'bg-tertiary', earnedAt: '5 hari lalu' },
    { id: 3, name: 'Pola Lanjutan', icon: 'workspace_premium', description: 'Selesaikan kursus bertingkat Advanced', color: 'bg-primary', earnedAt: 'Minggu ini' },
    { id: 4, name: 'Cepat Tepat', icon: 'bolt', description: 'Jawab 5 kuis berturut-turut dengan benar', color: 'bg-green-500', earnedAt: 'Kemarin' },
  ]);

  // Leaderboard (Global & Per Kursus)
  const leaderboard = ref([
    { id: 1, name: 'Sarah Jenkins', badge: 'Grand Master', exp: 4820, avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&q=80', trend: 120 },
    { id: 2, name: 'Alex', badge: 'Scholar', exp: 2450, avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuC8Aen3XuPxpgFCE5J2b6J7tZDlR1fjk-vWMzgbTfEFSnrx7WWGTHBI_MHu3bQHGuPgOlZgQgywrR0BjVhH2ukmK-TBy99kxqpMje9NopjNmczZbDI8xJfpGz2ZH7-PNt99FY8B3AgwcEY9QCcHK8iG9LpXfX4skqz3bAzvchrK-JWEu3E0KIr4q0R_z-eGEuXCv4vRcWRDZciFZbvySn54YgA8wxr_6UGpTqnFoa4imW5tWfKfDvwO3HPxIOLX6N1R7yndm_VxvvsO', trend: 45, isCurrentUser: true },
    { id: 3, name: 'Michael Chen', badge: 'Scholar', exp: 2100, avatar: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=150&q=80', trend: 30 },
    { id: 4, name: 'Priya Sharma', badge: 'Apprentice', exp: 1875, avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80', trend: 0 },
    { id: 5, name: 'James Wilson', badge: 'Apprentice', exp: 1540, avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80', trend: 15 },
  ]);

  // ── Getters ────────────────────────────────────────────────────────
  const expProgressPercent = computed(() =>
    Math.round((totalExp.value / expToNextLevel.value) * 100)
  );

  const expToLevel = computed(() => expToNextLevel.value - totalExp.value);

  const userRank = computed(() => {
    const idx = leaderboard.value.findIndex(u => u.isCurrentUser);
    return idx + 1;
  });

  // ── Actions ───────────────────────────────────────────────────────

  /**
   * Tambahkan EXP setelah video selesai atau kuis berhasil
   * @param {number} amount - jumlah EXP yang ditambahkan
   */
  const addExp = (amount) => {
    totalExp.value += amount;

    // Cek naik level
    if (totalExp.value >= expToNextLevel.value) {
      level.value++;
      expToNextLevel.value = Math.round(expToNextLevel.value * 1.5);
    }
  };

  /**
   * Perbarui streak harian
   */
  const incrementStreak = () => {
    currentStreak.value++;
    if (currentStreak.value > longestStreak.value) {
      longestStreak.value = currentStreak.value;
    }
  };

  const resetStreak = () => {
    currentStreak.value = 0;
  };

  /**
   * Tambahkan badge baru
   */
  const awardBadge = (badge) => {
    if (!earnedBadges.value.find(b => b.name === badge.name)) {
      earnedBadges.value.unshift({ ...badge, earnedAt: 'Baru saja' });
    }
  };

  return {
    currentStreak, longestStreak,
    totalExp, level, expToNextLevel, rankTier,
    earnedBadges,
    leaderboard,
    expProgressPercent, expToLevel, userRank,
    addExp, incrementStreak, resetStreak, awardBadge
  };
});

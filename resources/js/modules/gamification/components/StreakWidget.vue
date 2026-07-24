<template>
  <div class="space-y-4">
    <!-- Kartu Streaks Mingguan -->
    <div class="grid grid-cols-7 gap-1.5">
      <div
        v-for="(day, idx) in weekDays"
        :key="idx"
        class="flex flex-col items-center gap-1"
      >
        <div
          class="w-full aspect-square rounded-lg flex items-center justify-center text-sm font-bold transition-all duration-300"
          :class="day.completed
            ? 'bg-tertiary text-white shadow-md shadow-tertiary/30'
            : day.isToday
              ? 'bg-tertiary/20 border-2 border-tertiary border-dashed text-tertiary'
              : 'bg-surface-container-low text-secondary/40'"
        >
          <span
            class="material-symbols-outlined text-[18px]"
            v-if="day.completed"
            style="font-variation-settings: 'FILL' 1;"
          >local_fire_department</span>
          <span class="text-[11px]" v-else>{{ day.label }}</span>
        </div>
        <span class="text-[9px] text-secondary font-medium uppercase">{{ day.dayName }}</span>
      </div>
    </div>

    <!-- Stats Row -->
    <div class="flex items-center justify-between pt-2 border-t border-surface-container-low">
      <div class="text-center">
        <p class="text-[10px] text-secondary uppercase font-bold tracking-wider">Streak</p>
        <p class="font-bold text-on-surface text-lg">{{ currentStreak }} hari</p>
      </div>
      <div class="text-center">
        <p class="text-[10px] text-secondary uppercase font-bold tracking-wider">Terbaik</p>
        <p class="font-bold text-on-surface text-lg">{{ longestStreak }} hari</p>
      </div>
      <div class="text-center">
        <p class="text-[10px] text-secondary uppercase font-bold tracking-wider">Bulan Ini</p>
        <p class="font-bold text-on-surface text-lg">{{ monthlyDays }} hari</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  currentStreak: { type: Number, default: 12 },
  longestStreak: { type: Number, default: 21 },
  monthlyDays: { type: Number, default: 18 }
});

const weekDays = computed(() => {
  const days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
  const todayIdx = new Date().getDay(); // 0=Sun, 1=Mon...
  const adjustedToday = todayIdx === 0 ? 6 : todayIdx - 1; // Convert to Mon=0

  return days.map((d, i) => ({
    label: d,
    dayName: d,
    isToday: i === adjustedToday,
    completed: i < adjustedToday, // Days before today are completed
  }));
});
</script>

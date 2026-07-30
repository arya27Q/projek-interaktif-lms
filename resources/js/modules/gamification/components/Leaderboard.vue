<template>
  <div class="space-y-3">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
      <div class="flex gap-3">
        <button
          v-for="filter in filters"
          :key="filter.id"
          @click="activeFilter = filter.id"
          class="px-3 py-1.5 rounded-full text-xs font-bold transition-all"
          :class="activeFilter === filter.id
            ? 'bg-primary text-white shadow-sm'
            : 'bg-surface-container-low text-secondary hover:text-on-surface'"
        >
          {{ filter.label }}
        </button>
      </div>
      <span class="text-[10px] text-secondary font-bold uppercase tracking-wider">Minggu Ini</span>
    </div>

    <!-- Leaderboard List -->
    <div class="space-y-2">
      <div
        v-for="(user, idx) in filteredList"
        :key="user.id"
        class="flex items-center gap-3 p-3 rounded-xl transition-all duration-200"
        :class="user.isCurrentUser
          ? 'bg-primary/5 border border-primary/15 relative overflow-hidden'
          : idx < 3 ? 'bg-surface-container-low' : 'hover:bg-surface-container-low'"
      >
        <!-- Highlight bar untuk current user -->
        <div v-if="user.isCurrentUser" class="absolute left-0 top-0 bottom-0 w-1 bg-primary rounded-full"></div>

        <!-- Rank -->
        <div class="w-7 text-center shrink-0">
          <span v-if="idx === 0" class="text-lg">🥇</span>
          <span v-else-if="idx === 1" class="text-lg">🥈</span>
          <span v-else-if="idx === 2" class="text-lg">🥉</span>
          <span v-else class="font-bold text-secondary text-sm">{{ idx + 1 }}</span>
        </div>

        <!-- Avatar -->
        <div class="w-9 h-9 rounded-full overflow-hidden border-2 shrink-0"
          :class="user.isCurrentUser ? 'border-primary' : 'border-surface-container-low'">
          <img :src="user.avatar" :alt="user.name" class="w-full h-full object-cover" />
        </div>

        <!-- Name & Badge -->
        <div class="flex-1 min-w-0">
          <p class="font-bold text-sm truncate" :class="user.isCurrentUser ? 'text-primary' : 'text-on-surface'">
            {{ user.name }}
            <span v-if="user.isCurrentUser" class="text-[10px] font-normal text-primary/70"> (Kamu)</span>
          </p>
          <p class="text-[11px] text-secondary">{{ user.badge }}</p>
        </div>

        <!-- EXP & Trend -->
        <div class="text-right shrink-0">
          <p class="font-bold text-sm" :class="user.isCurrentUser ? 'text-primary' : 'text-on-surface'">
            {{ user.exp.toLocaleString('id-ID') }} EXP
          </p>
          <p class="text-[11px] flex items-center justify-end gap-0.5"
            :class="user.trend > 0 ? 'text-green-500' : 'text-secondary'">
            <span class="material-symbols-outlined text-[12px]" v-if="user.trend > 0">trending_up</span>
            {{ user.trend > 0 ? '+' + user.trend : '-' }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { gamificationApi } from '@/services/api';

const activeFilter = ref('global');
const isLoading = ref(true);

const filters = [
  { id: 'global', label: 'Global' },
  { id: 'course', label: 'Per Kursus' }
];

const leaderboardData = ref([]);

onMounted(async () => {
  try {
    const response = await gamificationApi.getLeaderboard(activeFilter.value);
    if (response && response.data) {
      leaderboardData.value = response.data;
    }
  } catch (error) {
    console.error('Gagal mengambil data leaderboard:', error);
  } finally {
    isLoading.value = false;
  }
});

const filteredList = computed(() => leaderboardData.value);
</script>

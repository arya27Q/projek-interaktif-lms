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
import { ref, computed } from 'vue';

const activeFilter = ref('global');

const filters = [
  { id: 'global', label: 'Global' },
  { id: 'course', label: 'Per Kursus' }
];

const leaderboardData = [
  { id: 1, name: 'Sarah Jenkins', badge: 'Grand Master', exp: 4820, avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&q=80', trend: 120 },
  { id: 2, name: 'Alex (Kamu)', badge: 'Scholar', exp: 2450, avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuC8Aen3XuPxpgFCE5J2b6J7tZDlR1fjk-vWMzgbTfEFSnrx7WWGTHBI_MHu3bQHGuPgOlZgQgywrR0BjVhH2ukmK-TBy99kxqpMje9NopjNmczZbDI8xJfpGz2ZH7-PNt99FY8B3AgwcEY9QCcHK8iG9LpXfX4skqz3bAzvchrK-JWEu3E0KIr4q0R_z-eGEuXCv4vRcWRDZciFZbvySn54YgA8wxr_6UGpTqnFoa4imW5tWfKfDvwO3HPxIOLX6N1R7yndm_VxvvsO', trend: 45, isCurrentUser: true },
  { id: 3, name: 'Michael Chen', badge: 'Scholar', exp: 2100, avatar: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=150&q=80', trend: 30 },
  { id: 4, name: 'Priya Sharma', badge: 'Apprentice', exp: 1875, avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80', trend: 0 },
  { id: 5, name: 'James Wilson', badge: 'Apprentice', exp: 1540, avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80', trend: 15 },
];

const filteredList = computed(() => leaderboardData);
</script>

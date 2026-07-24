<template>
  <div>
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
      <div>
        <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Studio Analytics</h2>
        <p class="text-secondary font-body-md">Track performance, engagement, and revenue for your NexLearn curriculum.</p>
      </div>
      <div class="flex items-center gap-3">
        <button class="flex items-center gap-2 px-5 py-2.5 bg-surface-container-lowest border border-surface-container-low rounded-lg font-label-sm hover:shadow-md transition-all active:scale-95">
          <span class="material-symbols-outlined">calendar_today</span>
          Last 30 Days
        </button>
        <button class="flex items-center gap-2 px-5 py-2.5 bg-primary text-on-primary rounded-lg font-label-sm hover:bg-on-surface transition-all active:scale-95 shadow-md">
          <span class="material-symbols-outlined">add</span>
          Create Course
        </button>
      </div>
    </div>

    <!-- Stats Bento Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="glass-card animate-slide-up p-6 rounded-lg shadow-[0px_10px_30px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform" style="animation-delay: 0ms;">
        <div class="flex items-center justify-between mb-4">
          <div class="p-2 bg-primary-fixed rounded-lg text-primary">
            <span class="material-symbols-outlined">group</span>
          </div>
          <span class="text-xs font-bold text-tertiary-container bg-tertiary-fixed px-2 py-1 rounded-full">+12.5%</span>
        </div>
        <p class="text-secondary font-label-sm mb-1 uppercase tracking-wider">Total Students</p>
        <h3 class="text-display-lg font-bold">14,284</h3>
      </div>
      <div class="glass-card animate-slide-up p-6 rounded-lg shadow-[0px_10px_30px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform" style="animation-delay: 100ms;">
        <div class="flex items-center justify-between mb-4">
          <div class="p-2 bg-tertiary-fixed rounded-lg text-tertiary">
            <span class="material-symbols-outlined">payments</span>
          </div>
          <span class="text-xs font-bold text-primary-container bg-primary-fixed px-2 py-1 rounded-full">+8.2%</span>
        </div>
        <p class="text-secondary font-label-sm mb-1 uppercase tracking-wider">Net Revenue</p>
        <h3 class="text-display-lg font-bold">$24.5k</h3>
      </div>
      <div class="glass-card animate-slide-up p-6 rounded-lg shadow-[0px_10px_30px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform" style="animation-delay: 200ms;">
        <div class="flex items-center justify-between mb-4">
          <div class="p-2 bg-surface-container-high rounded-lg text-on-surface-variant">
            <span class="material-symbols-outlined">timer</span>
          </div>
          <span class="text-xs font-bold text-secondary bg-surface-container-high px-2 py-1 rounded-full">-2.1%</span>
        </div>
        <p class="text-secondary font-label-sm mb-1 uppercase tracking-wider">Avg. Watch Time</p>
        <h3 class="text-display-lg font-bold">42m</h3>
      </div>
      <div class="glass-card animate-slide-up p-6 rounded-lg shadow-[0px_10px_30px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform" style="animation-delay: 300ms;">
        <div class="flex items-center justify-between mb-4">
          <div class="p-2 bg-primary-fixed rounded-lg text-primary">
            <span class="material-symbols-outlined">grade</span>
          </div>
          <span class="text-xs font-bold text-primary-container bg-primary-fixed px-2 py-1 rounded-full">Stable</span>
        </div>
        <p class="text-secondary font-label-sm mb-1 uppercase tracking-wider">Course Rating</p>
        <h3 class="text-display-lg font-bold">4.88</h3>
      </div>
    </div>

    <!-- Analytics Visualizations -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
      <!-- Drop-off Rate Chart -->
      <div class="lg:col-span-2 glass-card animate-slide-up p-8 rounded-lg shadow-[0px_20px_40px_rgba(0,0,0,0.08)]" style="animation-delay: 400ms;">
        <div class="flex items-center justify-between mb-8">
          <div>
            <h4 class="font-headline-md text-on-surface">Video Retention Analysis</h4>
            <p class="text-secondary font-body-md">Drop-off rates across lecture timestamps</p>
          </div>
          <select class="bg-surface-container-low border-none rounded-lg text-label-sm focus:ring-primary outline-none">
            <option>Advanced CSS Grids - Module 4</option>
            <option>Intro to UI Design - Module 1</option>
          </select>
        </div>
        <div class="h-64 relative flex items-end justify-between gap-1 group">
          <!-- Simulated Chart Bars -->
          <div class="w-full h-full absolute inset-0 flex items-end justify-between pointer-events-none pb-6">
            <div class="h-[80%] w-px bg-surface-container-high"></div>
            <div class="h-[80%] w-px bg-surface-container-high"></div>
            <div class="h-[80%] w-px bg-surface-container-high"></div>
            <div class="h-[80%] w-px bg-surface-container-high"></div>
            <div class="h-[80%] w-px bg-surface-container-high"></div>
          </div>
          <!-- Drop-off Curve (Simulated with div heights) -->
          <div class="flex-1 bg-primary/10 hover:bg-primary/30 transition-all rounded-t h-[95%] relative group/bar">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 opacity-0 group-hover/bar:opacity-100 bg-on-surface text-white text-[10px] px-2 py-1 rounded transition-opacity whitespace-nowrap z-10">95%</div>
          </div>
          <div class="flex-1 bg-primary/15 hover:bg-primary/30 transition-all rounded-t h-[92%] relative group/bar"></div>
          <div class="flex-1 bg-primary/20 hover:bg-primary/30 transition-all rounded-t h-[88%] relative group/bar"></div>
          <div class="flex-1 bg-primary/30 hover:bg-primary/30 transition-all rounded-t h-[85%] relative group/bar"></div>
          <div class="flex-1 bg-primary/40 hover:bg-primary/30 transition-all rounded-t h-[72%] relative group/bar">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 opacity-0 group-hover/bar:opacity-100 bg-error text-white text-[10px] px-2 py-1 rounded transition-opacity whitespace-nowrap z-10">72% - Concept Gap</div>
          </div>
          <div class="flex-1 bg-primary/40 hover:bg-primary/30 transition-all rounded-t h-[70%] relative group/bar"></div>
          <div class="flex-1 bg-primary/35 hover:bg-primary/30 transition-all rounded-t h-[74%] relative group/bar"></div>
          <div class="flex-1 bg-primary/30 hover:bg-primary/30 transition-all rounded-t h-[76%] relative group/bar"></div>
          <div class="flex-1 bg-primary/25 hover:bg-primary/30 transition-all rounded-t h-[75%] relative group/bar"></div>
          <div class="flex-1 bg-primary/20 hover:bg-primary/30 transition-all rounded-t h-[72%] relative group/bar"></div>
          <div class="flex-1 bg-primary/40 hover:bg-primary/30 transition-all rounded-t h-[60%] relative group/bar">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 opacity-0 group-hover/bar:opacity-100 bg-error text-white text-[10px] px-2 py-1 rounded transition-opacity whitespace-nowrap z-10">60% - Exit Pt</div>
          </div>
          <div class="flex-1 bg-primary/50 hover:bg-primary/30 transition-all rounded-t h-[58%] relative group/bar"></div>
          <div class="flex-1 bg-primary/60 hover:bg-primary/30 transition-all rounded-t h-[55%] relative group/bar"></div>
          <div class="flex-1 bg-primary/70 hover:bg-primary/30 transition-all rounded-t h-[52%] relative group/bar"></div>
          <div class="flex-1 bg-primary/80 hover:bg-primary/30 transition-all rounded-t h-[48%] relative group/bar"></div>
        </div>
        <div class="flex justify-between mt-4 text-secondary font-label-sm">
          <span>0:00</span>
          <span>5:00</span>
          <span>10:00</span>
          <span>15:00</span>
          <span>20:00</span>
        </div>
      </div>

      <!-- Active Enrollment Card -->
      <div class="glass-card animate-slide-up p-8 rounded-lg shadow-[0px_20px_40px_rgba(0,0,0,0.08)] flex flex-col" style="animation-delay: 500ms;">
        <h4 class="font-headline-md text-on-surface mb-6">Course Health</h4>
        <div class="grow space-y-6">
          <div>
            <div class="flex justify-between text-label-sm mb-2">
              <span class="text-secondary">Quiz Completion</span>
              <span class="font-bold">88%</span>
            </div>
            <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
              <div class="h-full bg-primary rounded-full" style="width: 88%"></div>
            </div>
          </div>
          <div>
            <div class="flex justify-between text-label-sm mb-2">
              <span class="text-secondary">Positive Reviews</span>
              <span class="font-bold">94%</span>
            </div>
            <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
              <div class="h-full bg-primary rounded-full" style="width: 94%"></div>
            </div>
          </div>
          <div>
            <div class="flex justify-between text-label-sm mb-2">
              <span class="text-secondary">Student Questions</span>
              <span class="font-bold">12 Active</span>
            </div>
            <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
              <div class="h-full bg-tertiary-container rounded-full" style="width: 45%"></div>
            </div>
          </div>
        </div>
        <div class="mt-8 pt-6 border-t border-surface-container-high">
          <button class="w-full flex items-center justify-center gap-2 text-primary font-bold hover:gap-3 transition-all">
            View Detailed Insights
            <span class="material-symbols-outlined">trending_up</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Course Management List -->
    <div class="glass-card animate-slide-up p-8 rounded-lg shadow-[0px_20px_40px_rgba(0,0,0,0.08)]" style="animation-delay: 600ms;">
      <div class="flex items-center justify-between mb-8">
        <h4 class="font-headline-md text-on-surface">Active Courses</h4>
        <button class="text-secondary hover:text-primary transition-colors">
          <span class="material-symbols-outlined">filter_list</span>
        </button>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="border-b border-surface-container-low text-secondary font-label-sm uppercase tracking-wider">
              <th class="pb-4 font-semibold min-w-62.5">Course Title</th>
              <th class="pb-4 font-semibold">Status</th>
              <th class="pb-4 font-semibold">Enrollment</th>
              <th class="pb-4 font-semibold">Revenue</th>
              <th class="pb-4 font-semibold">Rating</th>
              <th class="pb-4 font-semibold text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="font-body-md text-on-surface">
            <!-- Table Row 1 -->
            <tr class="border-b border-surface-container-low hover:bg-surface-container-lowest transition-colors group">
              <td class="py-6">
                <div class="flex items-center gap-4">
                  <div class="w-12 h-12 rounded-lg bg-surface-container-high overflow-hidden shadow-sm shrink-0">
                    <img class="w-full h-full object-cover" alt="Thumbnail" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBNw6y_b42BKlLznFq3wzcwpdTHO8Ce2qWOnDSloPwOLiFDchp9jwajob_A5Qehu79daCxWBoXjbS1WnnVrdFRLNA-A9fTy4y6wFtOcjoybxtpG4gfuuteRWdEu_xqm0pgvxX4uNSY8-Ne9KHrE7YGlMoa9nD2T5NDi1AA5rnrTcSFnsg17GSwh0w9BUQECHoQ5oywHoN2bmw8Vxusz1fiysN6sbjmLQ7NE2wbnK07SMs8fzuzK4-eib53OIlpnYMwqzFFEDyYC3Kf1"/>
                  </div>
                  <div>
                    <p class="font-bold">Mastering Advanced CSS Layouts</p>
                    <p class="text-xs text-secondary">Updated 2 days ago</p>
                  </div>
                </div>
              </td>
              <td class="py-6">
                <span class="px-3 py-1 bg-primary-fixed text-primary text-[10px] font-bold rounded-full uppercase tracking-tighter">Live</span>
              </td>
              <td class="py-6 font-bold">8,421</td>
              <td class="py-6">$12,450</td>
              <td class="py-6">
                <div class="flex items-center gap-1 text-tertiary">
                  <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="font-bold">4.9</span>
                </div>
              </td>
              <td class="py-6 text-right">
                <div class="flex items-center justify-end gap-2 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                  <button class="p-2 hover:bg-surface-container-low rounded-lg text-primary" title="Edit Course">
                    <span class="material-symbols-outlined">edit</span>
                  </button>
                  <button class="p-2 hover:bg-surface-container-low rounded-lg text-secondary" title="View Public Page">
                    <span class="material-symbols-outlined">visibility</span>
                  </button>
                </div>
              </td>
            </tr>
            
            <!-- Table Row 2 -->
            <tr class="border-b border-surface-container-low hover:bg-surface-container-lowest transition-colors group">
              <td class="py-6">
                <div class="flex items-center gap-4">
                  <div class="w-12 h-12 rounded-lg bg-surface-container-high overflow-hidden shadow-sm shrink-0">
                    <img class="w-full h-full object-cover" alt="Thumbnail" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCdo2yOw4-RgGMQEeJtORjrO_1jB0Oug2LuGXG5OrIi-yGYKSnpbwCKdhZghmGdFpKwF--0wGYmRfm2ISMt4PZ-SRqRcRB3cvqELM6-Bimvxf0S0cMkTpd-49hmqI-pOxXoNw4cyBEx7PUL0FI_WUWpWtfgewfFHc3y7M21_OwKlq8j6UiI0ANqLXnBfwtEis2zkKHwCZ01PUMFQaRMhpj2Xhz8GfRacfGJvM_F3mHevob5suW7PbjAzqCHTxtjzldpLGbZKdD5CCYX"/>
                  </div>
                  <div>
                    <p class="font-bold">JavaScript: The Performance Guide</p>
                    <p class="text-xs text-secondary">Updated 1 week ago</p>
                  </div>
                </div>
              </td>
              <td class="py-6">
                <span class="px-3 py-1 bg-primary-fixed text-primary text-[10px] font-bold rounded-full uppercase tracking-tighter">Live</span>
              </td>
              <td class="py-6 font-bold">5,863</td>
              <td class="py-6">$9,120</td>
              <td class="py-6">
                <div class="flex items-center gap-1 text-tertiary">
                  <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="font-bold">4.8</span>
                </div>
              </td>
              <td class="py-6 text-right">
                <div class="flex items-center justify-end gap-2 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                  <button class="p-2 hover:bg-surface-container-low rounded-lg text-primary">
                    <span class="material-symbols-outlined">edit</span>
                  </button>
                  <button class="p-2 hover:bg-surface-container-low rounded-lg text-secondary">
                    <span class="material-symbols-outlined">visibility</span>
                  </button>
                </div>
              </td>
            </tr>
            
            <!-- Table Row 3 -->
            <tr class="border-b border-surface-container-low hover:bg-surface-container-lowest transition-colors group">
              <td class="py-6">
                <div class="flex items-center gap-4">
                  <div class="w-12 h-12 rounded-lg bg-surface-container-high overflow-hidden shadow-sm shrink-0">
                    <img class="w-full h-full object-cover" alt="Thumbnail" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCcl9wqJTXB_JycnrHqcFi5ohXvmYqWEB37MC2tENWlcSQaLnNsNekKDHo05Q2ht-I1WSqONP80qcxj36ht-YwvNyehsOsonfjAgD2231Fmz1jBD2DluFBNifSTISMaS9wrNYFs4-3pUqntL2HOBuMfQARPVbYCMq4xaLc5mJfR9nJDDhyBTQ6t3APB-SEewWBEQ0ySOKBHaaDmKtVZJWvrHZyfAKZWWJyhUk1kbBWlc2Do1GaFRWBmg3WH9gpvEnGsd25kqjMQU1ey"/>
                  </div>
                  <div>
                    <p class="font-bold">Productivity for Digital Creatives</p>
                    <p class="text-xs text-secondary">Draft</p>
                  </div>
                </div>
              </td>
              <td class="py-6">
                <span class="px-3 py-1 bg-surface-container-high text-secondary text-[10px] font-bold rounded-full uppercase tracking-tighter">Draft</span>
              </td>
              <td class="py-6 font-bold">--</td>
              <td class="py-6">--</td>
              <td class="py-6">
                <div class="flex items-center gap-1 text-secondary">
                  <span class="material-symbols-outlined text-[16px]">star</span>
                  <span class="font-bold">N/A</span>
                </div>
              </td>
              <td class="py-6 text-right">
                <div class="flex items-center justify-end gap-2 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                  <button class="p-2 hover:bg-surface-container-low rounded-lg text-primary">
                    <span class="material-symbols-outlined">edit</span>
                  </button>
                  <button class="p-2 hover:bg-surface-container-low rounded-lg text-secondary">
                    <span class="material-symbols-outlined">visibility</span>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
// The animations are handled via CSS instead of Javascript DOM manipulation for better Vue integration
</script>

<style scoped>
.glass-card {
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(243, 244, 246, 1);
}

.animate-slide-up {
  opacity: 0;
  animation: slideUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>

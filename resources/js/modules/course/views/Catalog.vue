<template>
  <div>
    <!-- Hero Section -->
    <section class="mb-12">
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
          <h2 class="font-display-lg-mobile text-display-lg-mobile lg:font-display-lg lg:text-display-lg text-on-surface mb-2">Jelajahi Katalog</h2>
          <p class="font-body-lg text-secondary max-w-2xl">Kuasai keahlian baru dengan kurikulum dari para ahli. Setiap kursus dirancang untuk menantang pemahamanmu dan mempercepat pertumbuhan kariermu.</p>
        </div>
        <div class="flex gap-4">
          <button class="flex items-center gap-2 px-6 py-3 bg-surface-container-highest text-on-surface font-label-sm rounded-lg hover:bg-surface-variant transition-colors">
            <span class="material-symbols-outlined">tune</span>
            Filter
          </button>
          <button class="flex items-center gap-2 px-6 py-3 bg-on-surface text-surface font-label-sm rounded-lg hover:-translate-y-0.5 transition-transform">
            Urutkan: Terpopuler
            <span class="material-symbols-outlined">expand_more</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Filter Pills -->
    <section class="mb-8">
      <div class="flex flex-wrap gap-3 mb-4">
        <span 
          v-for="cat in categories" 
          :key="cat"
          @click="selectCategory(cat)"
          :class="[
            'px-4 py-2 rounded-full font-label-sm cursor-pointer transition-colors',
            selectedCategory === cat 
              ? 'bg-primary text-on-primary shadow-sm' 
              : 'bg-white text-secondary border border-surface-container-low hover:border-primary'
          ]"
        >
          {{ cat }}
        </span>
      </div>
      
      <!-- Subcategories for Computer Science -->
      <div v-if="selectedCategory === 'Ilmu Komputer'" class="flex flex-wrap gap-2 pl-4 border-l-2 border-primary-fixed animate-slide-up" style="animation-duration: 0.3s">
        <span 
          v-for="sub in csSubcategories" 
          :key="sub"
          @click="selectSubcategory(sub)"
          :class="[
            'px-3 py-1.5 rounded-full text-[12px] font-label-sm cursor-pointer transition-colors',
            selectedSubcategory === sub 
              ? 'bg-tertiary-container text-on-tertiary-container shadow-sm' 
              : 'bg-surface-container-lowest text-secondary border border-surface-container hover:bg-surface-container-low'
          ]"
        >
          {{ sub }}
        </span>
      </div>
    </section>

    <!-- Course Grid -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
      <template v-for="(course, index) in visibleCourses" :key="index">
        <!-- Learning Path Card -->
        <router-link 
          :to="'/checkout/' + (index + 1)"
          v-if="course.isLearningPath"
          class="course-card bg-inverse-surface rounded-lg p-8 shadow-[0px_10px_30px_rgba(0,0,0,0.04)] border border-surface-container-low flex flex-col justify-between h-full transition-all duration-300 cursor-pointer hover:-translate-y-1 hover:shadow-xl"
        >
          <div>
            <span class="inline-block bg-primary text-on-primary px-3 py-1 rounded-full font-label-sm text-xs font-bold uppercase tracking-wider mb-4">Alur Belajar</span>
            <h3 class="font-headline-md text-headline-md text-on-error font-bold leading-tight mb-3">{{ course.title }}</h3>
            <p class="font-body-md text-secondary-fixed-dim line-clamp-3 mb-6">{{ course.description }}</p>
          </div>
          <button class="mt-8 w-full bg-surface-container-lowest text-on-surface font-label-sm py-3 rounded-lg hover:bg-surface-container-low transition-colors font-semibold pointer-events-none">Lihat Alur</button>
        </router-link>

        <!-- Normal / Featured Card -->
        <router-link 
          :to="'/checkout/' + (index + 1)"
          v-else
          class="course-card group bg-surface-container-lowest rounded-lg p-5 shadow-[0px_10px_30px_rgba(0,0,0,0.04)] border border-surface-container-low flex flex-col h-full transition-all duration-300 cursor-pointer hover:-translate-y-1 hover:shadow-lg"
          :class="{ 'md:col-span-2': course.isFeatured }"
        >
          <div class="relative w-full rounded-lg overflow-hidden mb-5 bg-surface-container-high" :class="course.isFeatured ? 'h-64' : 'h-48'">
            <img class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" :class="!course.isFeatured && course.level === 'Intermediate' ? 'mix-blend-multiply' : ''" :alt="course.title" :src="course.thumbnail_url || 'https://via.placeholder.com/600x400.png?text=Course'"/>
            <div v-if="course.isFeatured" class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>
            <div v-if="course.isFeatured" class="absolute top-4 left-4 bg-primary text-on-primary px-3 py-1 rounded-full font-label-sm text-xs font-bold uppercase tracking-wider">Pilihan</div>
            <div :class="course.isFeatured ? 'absolute bottom-4 right-4 text-white font-label-sm' : 'absolute top-3 right-3 px-3 py-1 bg-white/90 backdrop-blur-sm text-primary font-label-sm rounded-full'">
              4.8 ★
            </div>
          </div>
          <div class="flex-1 flex flex-col">
            <div class="flex items-center gap-2 mb-2">
              <span v-if="course.level" class="px-2 py-0.5 bg-surface-container-low text-secondary font-code text-[12px] rounded uppercase tracking-wider">{{ course.level }}</span>
              <span v-if="course.duration" class="text-secondary font-label-sm">• {{ course.duration }}</span>
            </div>

            <div class="flex justify-between items-start mb-2">
              <h3 class="font-headline-md text-headline-md text-on-surface mb-3 leading-tight group-hover:text-primary transition-colors" :class="{'line-clamp-2': !course.isFeatured}">{{ course.title }}</h3>
              <button class="text-secondary hover:text-primary transition-colors shrink-0 ml-2"><span class="material-symbols-outlined" :class="{'text-[20px]': !course.isFeatured}">bookmark_border</span></button>
            </div>
            <p v-if="course.description" class="font-body-md text-secondary mb-4 line-clamp-2" :class="{'text-sm': !course.isFeatured}">{{ course.description }}</p>
            
            <div v-if="course.instructor" class="mt-auto flex items-center gap-3 mb-4">
              <div v-if="course.isFeatured" class="h-8 w-8 rounded-full bg-surface-container-high overflow-hidden border border-surface-variant grayscale shrink-0">
                <img class="w-full h-full object-cover" :alt="course.instructor.name" :src="course.instructor.avatar || 'https://ui-avatars.com/api/?name=' + course.instructor.name"/>
              </div>
              <span class="font-body-md text-secondary">{{ course.instructor.name }}</span>
            </div>
          </div>
          <div v-if="course.price !== undefined || course.exp" class="mt-auto pt-4 border-t border-surface-container-low flex flex-wrap items-center justify-between gap-y-3 gap-x-2">
            <div v-if="course.exp" class="flex items-center gap-1 text-primary whitespace-nowrap">
              <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">stars</span>
              <span class="font-label-sm font-bold">{{ course.exp }} EXP</span>
            </div>
            <span v-if="course.price !== undefined" class="font-headline-md text-on-surface whitespace-nowrap shrink-0 ml-auto">{{ course.price == 0 ? 'Gratis' : 'Rp ' + course.price.toLocaleString('id-ID') }}</span>
          </div>
        </router-link>
      </template>
    </section>
    
    <!-- Pagination/Load More -->
    <div class="mt-16 flex flex-col items-center gap-4">
      <button 
        v-if="hasMore" 
        @click="loadMore"
        class="px-8 py-4 bg-white border border-surface-container-low text-on-surface font-label-sm rounded-lg hover:bg-surface-container-low transition-all shadow-sm active:scale-95 flex items-center gap-2"
        :class="{'opacity-75 cursor-wait': isLoading}"
        :disabled="isLoading"
      >
        <span v-if="isLoading" class="material-symbols-outlined animate-spin">progress_activity</span>
        {{ isLoading ? 'Memuat...' : 'Muat Lebih Banyak Kursus' }}
      </button>
      <p class="font-body-md text-secondary">Menampilkan {{ visibleCourses.length }} dari {{ filteredCourses.length }} kursus</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { categories, csSubcategories } from '../../../data/mockCourses.js';

const selectedCategory = ref('Semua Kategori');
const selectedSubcategory = ref('Semua');

const selectCategory = (cat) => {
  selectedCategory.value = cat;
  if (cat !== 'Ilmu Komputer') {
    selectedSubcategory.value = 'Semua';
  }
  visibleCount.value = 6;
};

const selectSubcategory = (sub) => {
  selectedSubcategory.value = sub;
  visibleCount.value = 6;
};

// State
const allCourses = ref([]);
const visibleCount = ref(6);
const isLoading = ref(true);

const fetchCourses = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get('/courses');
    allCourses.value = response.data.data;
  } catch (error) {
    console.error('Error fetching courses:', error);
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  fetchCourses();
});

const filteredCourses = computed(() => {
  return allCourses.value.filter(course => {
    if (selectedCategory.value !== 'Semua Kategori' && course.category !== selectedCategory.value) {
      return false;
    }
    if (selectedCategory.value === 'Ilmu Komputer' && selectedSubcategory.value !== 'Semua' && course.subcategory !== selectedSubcategory.value) {
      return false;
    }
    return true;
  });
});

const visibleCourses = computed(() => {
  return filteredCourses.value.slice(0, visibleCount.value);
});

const hasMore = computed(() => {
  return visibleCount.value < filteredCourses.value.length;
});

const loadMore = () => {
  if (isLoading.value) return;
  isLoading.value = true;
  
  // Simulate network request
  setTimeout(() => {
    // Load 6 more courses at a time
    visibleCount.value = Math.min(visibleCount.value + 6, allCourses.value.length);
    isLoading.value = false;
  }, 600);
};
</script>

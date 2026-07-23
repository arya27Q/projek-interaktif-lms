<template>
  <div>
    <!-- Hero Section -->
    <section class="mb-12">
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
          <h2 class="font-display-lg-mobile text-display-lg-mobile lg:font-display-lg lg:text-display-lg text-on-surface mb-2">Explore the Catalog</h2>
          <p class="font-body-lg text-secondary max-w-2xl">Master new skills with our expert-led curricula. Each course is designed to challenge your understanding and accelerate your career growth.</p>
        </div>
        <div class="flex gap-4">
          <button class="flex items-center gap-2 px-6 py-3 bg-surface-container-highest text-on-surface font-label-sm rounded-lg hover:bg-surface-variant transition-colors">
            <span class="material-symbols-outlined">tune</span>
            Filters
          </button>
          <button class="flex items-center gap-2 px-6 py-3 bg-on-surface text-surface font-label-sm rounded-lg hover:-translate-y-0.5 transition-transform">
            Sort: Popularity
            <span class="material-symbols-outlined">expand_more</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Filter Pills -->
    <section class="mb-8 flex flex-wrap gap-3">
      <span class="px-4 py-2 bg-primary text-on-primary rounded-full font-label-sm cursor-pointer shadow-sm">All Categories</span>
      <span class="px-4 py-2 bg-white text-secondary border border-surface-container-low rounded-full font-label-sm hover:border-primary transition-colors cursor-pointer">Computer Science</span>
      <span class="px-4 py-2 bg-white text-secondary border border-surface-container-low rounded-full font-label-sm hover:border-primary transition-colors cursor-pointer">Visual Design</span>
      <span class="px-4 py-2 bg-white text-secondary border border-surface-container-low rounded-full font-label-sm hover:border-primary transition-colors cursor-pointer">Business Strategy</span>
      <span class="px-4 py-2 bg-white text-secondary border border-surface-container-low rounded-full font-label-sm hover:border-primary transition-colors cursor-pointer">Data Analytics</span>
      <span class="px-4 py-2 bg-white text-secondary border border-surface-container-low rounded-full font-label-sm hover:border-primary transition-colors cursor-pointer">Marketing</span>
      <span class="px-4 py-2 bg-white text-secondary border border-surface-container-low rounded-full font-label-sm hover:border-primary transition-colors cursor-pointer">Philosophy</span>
    </section>

    <!-- Course Grid -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
      <div 
        v-for="(course, index) in visibleCourses" 
        :key="index"
        class="course-card group bg-surface-container-lowest rounded-lg p-5 shadow-[0px_10px_30px_rgba(0,0,0,0.04)] border border-surface-container-low flex flex-col h-full transition-all duration-300 cursor-pointer hover:-translate-y-1 hover:shadow-lg"
      >
        <div class="relative w-full h-48 rounded-lg overflow-hidden mb-5 bg-surface-container-high">
          <img class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" :alt="course.title" :src="course.thumbnail"/>
          <div class="absolute top-3 right-3 px-3 py-1 bg-white/90 backdrop-blur-sm text-primary font-label-sm rounded-full">
            {{ course.rating }} ★
          </div>
        </div>
        <div class="flex-1 flex flex-col">
          <div class="flex items-center gap-2 mb-2">
            <span class="px-2 py-0.5 bg-surface-container-low text-secondary font-code text-[12px] rounded uppercase tracking-wider">{{ course.level }}</span>
            <span class="text-secondary font-label-sm">• {{ course.duration }}</span>
          </div>
          <h3 class="font-headline-md text-headline-md text-on-surface mb-3 leading-tight group-hover:text-primary transition-colors line-clamp-2">{{ course.title }}</h3>
          
          <!-- Spacer to push instructor down -->
          <div class="mt-auto flex items-center gap-3 mb-4">
            <div class="h-8 w-8 rounded-full bg-surface-container-high overflow-hidden border border-surface-variant">
              <img class="w-full h-full object-cover" :alt="course.instructor" :src="course.instructorAvatar"/>
            </div>
            <span class="font-body-md text-secondary">{{ course.instructor }}</span>
          </div>
        </div>
        <div class="pt-4 border-t border-surface-container-low flex items-center justify-between">
          <div class="flex items-center gap-1 text-primary">
            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">stars</span>
            <span class="font-label-sm font-bold">{{ course.exp }} EXP</span>
          </div>
          <span class="font-headline-md text-on-surface">{{ course.price }}</span>
        </div>
      </div>
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
        {{ isLoading ? 'Loading...' : 'Load More Courses' }}
      </button>
      <p class="font-body-md text-secondary">Showing {{ visibleCourses.length }} of {{ allCourses.length }} courses</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// The 6 base courses from the original HTML
const baseCourses = [
  {
    title: 'Advanced Systems Architecture & Scaling',
    level: 'Intermediate',
    duration: '12h 30m',
    instructor: 'Dr. Aris Thorne',
    rating: '4.9',
    exp: '500',
    price: '$89.99',
    thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuC34pPW97Bpwzwb5JR859P7810vgImBAhLL_rDOKFvMKWUoDbdDIokyt91YvTi55RHebif14A7Dnn4kOjaAv94IkOKEDmVzysVuZIl0PFWCn1PUOAg95cN9cc3ym_xbWFTEKMSo4IqUJ0ceSLKZqn5eRvusu03hCa-oi6el_6xUYgOHGoAKDlTvzGNuz9Ztn2PjKaOKNylOYRZ7C_Lx1NQaAJrEiqosfX7eYcyf-E1HA_0-tn6C5aR9qHgWNPWdv4Y7JD-Ar8K4u4lt',
    instructorAvatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDTvov2PRgclMqp1g1ji1_9CKvbBFymNVrnTDHujhIji4BhBF-5gcbQ-qMH28-aOnObRspv4pgufFe6HpRGFlHfhuE1tTmAzMSrZldRDA4A-KnhRPEY9ThlKP1OoRM_spQQsv8jLo2XhnCMhKg-n5JESAiQSy4bkiI2nLOF9oSFX5NwL-gPSB9bO1Z3BZ1-xv1sWnjQRyBIS_0-_YBmBUrQNQKeG5Dhf-59G4BVSwGHZ1SPWEnB8MEiHDcgDv0fx_M-t-e51P5BZMay'
  },
  {
    title: 'Modern Principles of Visual Identity',
    level: 'Beginner',
    duration: '8h 15m',
    instructor: 'Marcus Vane',
    rating: '4.7',
    exp: '350',
    price: '$54.00',
    thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAQx9jqE1XBroMq8yxxzc6-MT_wiklCrMdmKyMSuS4WXwIyCb_AXB2j53fyRlNKoec3oE5BoAwV4nbrvTrPCw2PcINzmHIe5wBxPnZfPQT5x_8u_J-CcAjhx_mlC9Hqy_vEbFopah9QlSstUUKst5Z3eqFN8Aw0DCiULMWq7YK_-jkhcBRJTnEhfcigCB_9OZEyTWrO3ywV8-1KN9pFq29X-VVUapESoQexd13Dq1lm-nVLxQMNUjNlrB4NkjvJx9VdJk1qaKlS8bXn',
    instructorAvatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAMIKNEAgwY4y0vn21iItl9CPipYJevEE3PGp2nY_NJceq0YEcd9jbgOPVn9WPUUeC7P7lqeVyxy_FaNm_-H1NelazF_6HUPe0f5xWc3nqvOI2000wOpbpOnPOCHH1QkdB7iznL7ocqAf27nl1fbxunITW2OiIojjbmd2UBp1RT-d-RFPaqRM2A8bu8paQMbix07gRZrMDNlzz-ZmtAyYxCtQY0qlrcGWY4Izy4bC8BLuOXqbM3ePe6EhYzGPyzmjskreqVOOu_lGLT'
  },
  {
    title: 'Algorithmic Trading & Risk Control',
    level: 'Mastery',
    duration: '22h 45m',
    instructor: 'Kenzo Nakamura',
    rating: '5.0',
    exp: '1,200',
    price: '$149.99',
    thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAh3Dr1-VnxIseyTO9B9_Qrp6C9WGZXOFa0-l_FX3bGRkdwdBgV2f8YkYy8G77Jyi8MqWES8pcFGVHY6fVs-nF-9KNnvYbeaq5U86y35cF3p6PYWR7toNAsL6-TXhi-4TbR76kJAe7qDtU1kWdAcmyPrbXe3lU4h_ppMywvqHNuqANfo4K0tlfZ_DWSvXONxH9I8g_AeR3w-u4PP4PhJaNfmsGPmPvwhNqQiQrdzTprE7bBn2cuUxLN9qG7z5h-oLfjHT5jiWQExmjl',
    instructorAvatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuC1kJcBwnCJFhxEQcpJuLCTpR3KJ5xO59w5pvFWfMdlr0us90F-D-v6ZSWKGbq0OyhYo_cPyDoqHFEqftc8Q2OdmZq4ThLs17nrRYEVxz0JStS6qv7ue-5oUdiLMBdwD9sEfHpT_b3ShyDrhwUGa-2FeTfS8juoA_DA6QA80GgY7yCD9MuqB4q9ID1derR9v11Q_vmk15rjt81whi9hgjhXTPugi2aK7l2lcD7eRKuwuuPjyzqgW1PosTKXUt6NEZ3gPdMu_RL61SLs'
  },
  {
    title: 'Foundations of Cognitive Science',
    level: 'Beginner',
    duration: '6h 20m',
    instructor: 'Dr. Elena Rodriguez',
    rating: '4.8',
    exp: '250',
    price: '$45.00',
    thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBwV5HrUkFPhEknjGFc2OluwtAfyt25X-gOl8KI-rPaKPLy-uSyPid8LnFoNpxYR-x6uofMFJUC32kenYxVy1tGnVkcGu1GRGCRLt_-vZ8miokzMaxzmpWFmXMrWZg-QWYS7nHcMinIHRng8nnsckSGgfwY-1cwoukqKqd1VMyiWDLuiqvtVghBmQTUKexdzdSXHdKY2n1eqnWR4AHQ7HxkNREr6NRDrtWNjEJ88jPCqMx467F3UJpn263KJcM8s_2AkA0lWsM26ahf',
    instructorAvatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDC98uovb7c0DmTIw0SCVE9C1xi6Ood1Cj95yoGNtLX-BjIBCiV1dPyurIWAx_O6LuUDHUKccjNpvNwQ07hDB9rmX0oOMttPU65qklpzdsWdLGe-RM-oJKrUs9FAb03W6NhW6z3GKwMAR-dAOq-_Dy5FkgYCQncB1mdUPpJDo7cfEN6B8jCGxl4YyIzl3JrIQW3qntkaHzq4RNtMUie1ODtnJegMRResS701Ep86mzN1pO2wPDkcdKpnm6o6AMm2kZeyaFf6n0pNYeJ'
  },
  {
    title: 'Creative Writing & Narrative Design',
    level: 'Intermediate',
    duration: '14h 0m',
    instructor: 'Julian Pierce',
    rating: '4.6',
    exp: '450',
    price: '$68.00',
    thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAWQjWbEZpmCtu3v3CQEuhAeb42hdEPGT89XaLp5WrVCnL89zU2cDt1czRMWqfdWxEsvc_3j3XiS7YwsHU10CcPLD8q76jWO9n7-KCRmA5NfSI3ZEA8qFv3HKkeVYbp1MgLgaN8hOF7Aj6PXxWdMO-UtpUCxTV6ewi08Qgr1J6NkLQ0icgZCmTU90eVrWqdkqAIbM0AoQ68wMmK4MR4VkeHK7CjY8L2RZoL7hjeXGM34pYddr0DRfC_h-f0nSupSvEJK94GwbOT5PXh',
    instructorAvatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBNWBb9-37--hZpJw3KhJMRVLs39q6hYG8bfg6n8cEEyV7frg7C07L_wHpHkea1sG9hxvYQFTcLkvYVj-oZoJaG3k9ts7YHf-AXUSnDSuph42NAt0NYBDi5y8evm30mM5HeHEkHN_1Tr97ltOGGUViEGROKgZVG9RrnXgWJ6DB8n_4EJ3KC4a1fK3YzXMvPuOxD4kLadbk6ezkXq6N7DPE_1SHqkPlzrxyvCbLAWT0veyB1WO7Pvmj04U5qzbtYVnsE2N7ejyAOht9D'
  },
  {
    title: 'Strategic Leadership in Global Markets',
    level: 'Mastery',
    duration: '30h 15m',
    instructor: 'Sarah Jenkins, MBA',
    rating: '4.9',
    exp: '2,000',
    price: '$199.00',
    thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAb8r-K61iN3J2AiQGRaqxoHvHrFSm-se1rGkpTQNA4vXALYoKT-CI0oCk_c2df4eNl1ppsw9Bz_5o7vrg2ND9aTSKQtcOGzXc1MMy4Tr_NktpW51XAO22ttsw1d-10O3X6tTZKX2jX9j63KkXgDKjnnGyz_mJVx0xi7K4p8ehd-JLido2tjwSWfsMaOQiDmES1v-0FmBvT4fZNts-wKVKi2z7ls99ksDWUwNXWiVOke9FYrz4evLiYgcyHpQrWJE7jdGdrWu25vE7c',
    instructorAvatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBLOl7pCIU98yWmPgtPDHJX2mNQd0kcXccW7LaeQNmKoxRzyW8ozYL3n7aZoJxjTQPopg7vUbV9d84s0JCtq02fBrKZw7C96P-QRCa7LU4saxjiZKOJS6C1MDuu7NERKbrKA5uMEWiG5hZ_3eIvDquxYQLGbzrHNwTdcUCekDg7iqKweXSnV8WkrbE-dFNybIykaPhYWxOxvnke30S-GXrwUrALSyYa0Nzh4SnpdHMrW3XUXISGucmEcqqxkzUw0rPxf_ax1xFVDYBq'
  }
];

// Generate a large list of courses by cloning the base ones with a slight modification
const generateCourses = (count) => {
  const result = [];
  for (let i = 0; i < count; i++) {
    const baseIndex = i % baseCourses.length;
    const base = baseCourses[baseIndex];
    result.push({
      ...base,
      // Add a suffix to make titles look unique
      title: i >= baseCourses.length ? `${base.title} (Vol. ${Math.floor(i / baseCourses.length) + 1})` : base.title
    });
  }
  return result;
};

// State
const allCourses = ref(generateCourses(245)); // Generate 245 courses as per the original HTML text "Showing 6 of 245 courses"
const visibleCount = ref(6);
const isLoading = ref(false);

const visibleCourses = computed(() => {
  return allCourses.value.slice(0, visibleCount.value);
});

const hasMore = computed(() => {
  return visibleCount.value < allCourses.value.length;
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

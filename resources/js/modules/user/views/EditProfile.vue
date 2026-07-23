<template>
  <div>
    <header class="mb-8 flex items-center gap-4">
      <router-link to="/profile" class="p-2 hover:bg-surface-container rounded-full transition-colors flex items-center justify-center">
        <span class="material-symbols-outlined text-on-surface">arrow_back</span>
      </router-link>
      <div>
        <h1 class="font-headline-md text-headline-md text-on-surface">Edit Profil</h1>
        <p class="text-on-surface-variant font-body-md text-body-md">Perbarui informasi dasar profil Anda</p>
      </div>
    </header>

    <div class="bg-surface rounded-3xl p-6 md:p-8 shadow-[0px_20px_40px_rgba(0,0,0,0.08)] max-w-2xl">
      <form @submit.prevent="handleSave" class="flex flex-col gap-6">
        
        <!-- Avatar Upload -->
        <div class="flex items-center gap-6 pb-6 border-b border-surface-container">
          <img alt="Alex Johnson" class="w-24 h-24 rounded-full object-cover shadow-sm" src="https://lh3.googleusercontent.com/aida-public/AB6AXuARvtnGkjYWdlvqWvjWweBnY5qWJEu4rr1rOhpojtH3Uml4tCUTlpw7Hw0XMGFXYZ2IYO0I2gqSTGGLEmSv27D6RB4rh0Fg7exqkZ9xNjVIHJg1GIAGy1qwV_bWgQYdW1TsdydXHDxScxYbkWDnTgtQXMan7_VJ1r4L7j39wV09jhh8tjaK3aDVYBcMkqysyPHax4h9olbX-M8HNUc8RAjH2UQYIUZRjVVrNCKCB7LChF3l985UyXlZLBqxMbQH12aSiLARdFpl4E9y"/>
          <div class="flex flex-col gap-2">
            <button type="button" class="px-4 py-2 bg-secondary-container text-on-secondary-container font-label-sm text-label-sm rounded-xl hover:bg-surface-container-highest transition-colors">
              Ubah Foto
            </button>
            <span class="text-xs text-on-surface-variant">JPG, GIF atau PNG. Maks 2MB.</span>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="flex flex-col gap-2">
            <label class="font-label-sm text-label-sm text-on-surface">Nama Lengkap</label>
            <input v-model="form.name" class="w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-md text-on-surface focus:border-on-surface focus:ring-1 focus:ring-on-surface transition-colors outline-none" type="text"/>
          </div>
          <div class="flex flex-col gap-2">
            <label class="font-label-sm text-label-sm text-on-surface">Email</label>
            <input v-model="form.email" class="w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-md text-on-surface focus:border-on-surface focus:ring-1 focus:ring-on-surface transition-colors outline-none opacity-70" type="email" readonly/>
          </div>
        </div>

        <div class="flex flex-col gap-2">
          <label class="font-label-sm text-label-sm text-on-surface">Bio</label>
          <textarea v-model="form.bio" rows="4" class="w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-md text-on-surface focus:border-on-surface focus:ring-1 focus:ring-on-surface transition-colors outline-none"></textarea>
        </div>

        <div class="flex justify-end gap-3 pt-4">
          <router-link to="/profile" class="px-6 py-3 text-secondary font-label-sm text-label-sm rounded-xl hover:bg-surface-container transition-colors">
            Batal
          </router-link>
          <button type="submit" class="px-6 py-3 bg-primary text-on-primary font-label-sm text-label-sm rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const form = reactive({
  name: 'Alex Johnson',
  email: 'alex.johnson@student.edu',
  bio: 'Sangat tertarik dengan AI dan Machine Learning. Sedang membangun proyek akhir yang keren!'
});

const handleSave = () => {
  console.log('Saved profile', form);
  router.push('/profile');
};
</script>

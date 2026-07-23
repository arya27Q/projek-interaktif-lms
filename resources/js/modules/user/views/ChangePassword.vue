<template>
  <div>
    <header class="mb-8 flex items-center gap-4">
      <router-link to="/profile" class="p-2 hover:bg-surface-container rounded-full transition-colors flex items-center justify-center">
        <span class="material-symbols-outlined text-on-surface">arrow_back</span>
      </router-link>
      <div>
        <h1 class="font-headline-md text-headline-md text-on-surface">Ubah Kata Sandi</h1>
        <p class="text-on-surface-variant font-body-md text-body-md">Pastikan akun Anda tetap aman dengan kata sandi yang kuat</p>
      </div>
    </header>

    <div class="bg-surface rounded-3xl p-6 md:p-8 shadow-[0px_20px_40px_rgba(0,0,0,0.08)] max-w-md">
      <form @submit.prevent="handleSave" class="flex flex-col gap-5">
        
        <div class="flex flex-col gap-2">
          <label class="font-label-sm text-label-sm text-on-surface">Kata Sandi Saat Ini</label>
          <div class="relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">lock</span>
            <input v-model="form.current_password" class="w-full pl-12 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-md text-on-surface focus:border-on-surface focus:ring-1 focus:ring-on-surface transition-colors outline-none" type="password" required/>
          </div>
        </div>

        <div class="flex flex-col gap-2">
          <label class="font-label-sm text-label-sm text-on-surface">Kata Sandi Baru</label>
          <div class="relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">key</span>
            <input v-model="form.new_password" class="w-full pl-12 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-md text-on-surface focus:border-on-surface focus:ring-1 focus:ring-on-surface transition-colors outline-none" type="password" required/>
          </div>
          <span class="text-xs text-on-surface-variant">Minimal 8 karakter, kombinasi huruf dan angka.</span>
        </div>

        <div class="flex flex-col gap-2">
          <label class="font-label-sm text-label-sm text-on-surface">Konfirmasi Kata Sandi Baru</label>
          <div class="relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">password</span>
            <input v-model="form.confirm_password" class="w-full pl-12 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-md text-on-surface focus:border-on-surface focus:ring-1 focus:ring-on-surface transition-colors outline-none" type="password" required/>
          </div>
        </div>

        <div class="flex justify-end gap-3 pt-4">
          <router-link to="/profile" class="px-6 py-3 text-secondary font-label-sm text-label-sm rounded-xl hover:bg-surface-container transition-colors">
            Batal
          </router-link>
          <button type="submit" class="px-6 py-3 bg-primary text-on-primary font-label-sm text-label-sm rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200">
            Perbarui Sandi
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
  current_password: '',
  new_password: '',
  confirm_password: ''
});

const handleSave = () => {
  console.log('Password changed', form);
  router.push('/profile');
};
</script>

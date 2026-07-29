<template>
  <div>
    <!-- Modal Cropper -->
    <ImageCropperModal 
      :show="showCropper" 
      :imageUrl="tempImageUrl"
      @close="showCropper = false"
      @crop="handleCropComplete"
    />

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
          <img alt="User Avatar" class="w-24 h-24 rounded-full object-cover shadow-sm" :src="form.avatar_base64 || form.current_avatar || 'https://lh3.googleusercontent.com/aida-public/AB6AXuARvtnGkjYWdlvqWvjWweBnY5qWJEu4rr1rOhpojtH3Uml4tCUTlpw7Hw0XMGFXYZ2IYO0I2gqSTGGLEmSv27D6RB4rh0Fg7exqkZ9xNjVIHJg1GIAGy1qwV_bWgQYdW1TsdydXHDxScxYbkWDnTgtQXMan7_VJ1r4L7j39wV09jhh8tjaK3aDVYBcMkqysyPHax4h9olbX-M8HNUc8RAjH2UQYIUZRjVVrNCKCB7LChF3l985UyXlZLBqxMbQH12aSiLARdFpl4E9y'"/>
          <div class="flex flex-col gap-2">
            <input type="file" ref="fileInput" accept="image/jpeg, image/png, image/webp" class="hidden" @change="onFileChange" />
            <button type="button" @click="$refs.fileInput.click()" class="px-5 py-2.5 bg-secondary-container text-on-secondary-container font-label-sm text-label-sm rounded-xl hover:bg-primary hover:text-on-primary hover:shadow-[0_4px_12px_rgba(0,0,0,0.15)] hover:-translate-y-0.5 active:scale-95 transition-all duration-300 cursor-pointer">
              Ubah Foto
            </button>
            <span class="text-xs text-on-surface-variant">JPG, WEBP atau PNG. Maks 2MB.</span>
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
import { reactive, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { authApi, userApi } from '@/services/api';
import ImageCropperModal from '@/components/ImageCropperModal.vue';

const router = useRouter();
const fileInput = ref(null);
const showCropper = ref(false);
const tempImageUrl = ref('');

const form = reactive({
  name: '',
  email: '',
  bio: '',
  current_avatar: '',
  avatar_base64: ''
});

onMounted(async () => {
  try {
    const response = await authApi.me();
    if (response && response.user) {
      form.name = response.user.name || '';
      form.email = response.user.email || '';
      form.bio = response.user.bio || '';
      form.current_avatar = response.user.avatar || '';
    }
  } catch (error) {
    console.error('Gagal mengambil data user:', error);
  }
});

const onFileChange = (e) => {
  const file = e.target.files[0];
  if (!file) return;
  
  if (file.size > 2 * 1024 * 1024) {
    alert('Ukuran file maksimal 2MB');
    return;
  }
  
  const reader = new FileReader();
  reader.onload = (event) => {
    tempImageUrl.value = event.target.result;
    showCropper.value = true;
  };
  reader.readAsDataURL(file);
  e.target.value = ''; // reset input
};

const handleCropComplete = (base64) => {
  form.avatar_base64 = base64;
  showCropper.value = false;
};

const handleSave = async () => {
  try {
    await userApi.updateProfile({
      name: form.name,
      bio: form.bio,
      avatar_base64: form.avatar_base64
    });
    router.push('/profile');
  } catch (error) {
    console.error('Gagal memperbarui profil:', error);
    alert('Gagal menyimpan profil. Silakan coba lagi.');
  }
};
</script>

<template>
  <div class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-background text-on-background relative w-full">
    <!-- Decorative background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
      <div class="absolute top-[-10%] left-[-5%] w-96 h-96 bg-primary-fixed-dim rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
      <div class="absolute top-[20%] right-[-10%] w-120 h-120 bg-tertiary-fixed rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
      <div class="absolute bottom-[-20%] left-[20%] w-80 h-80 bg-secondary-fixed rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>
    
    <!-- Toast Notification (Glassmorphism) -->
    <transition name="toast-fade">
      <div v-if="toast.show" 
           :class="['fixed top-10 left-1/2 -translate-x-1/2 px-6 py-4 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.2)] backdrop-blur-xl border border-white/20 z-[100] flex items-center gap-3 transition-all min-w-[300px] justify-center',
           toast.type === 'success' ? 'bg-emerald-500/90 text-white' : 'bg-rose-500/90 text-white']">
        <span class="material-symbols-outlined text-2xl">{{ toast.type === 'success' ? 'check_circle' : 'error' }}</span>
        <p class="font-body-md font-medium tracking-wide">{{ toast.message }}</p>
      </div>
    </transition>

    <!-- Registration Card -->
    <main class="w-full max-w-md z-10">
      <div class="glass-card rounded-[20px] p-6 md:p-10 w-full relative overflow-hidden">
        <!-- Header -->
        <div class="text-center mb-6 md:mb-8">
          <h1 class="font-headline-md text-headline-md font-bold text-primary mb-2">NexLearn</h1>
          <h2 class="font-headline-md text-headline-md text-on-background mb-1">Mulai Belajar Sekarang</h2>
          <p class="font-body-md text-body-md text-on-surface-variant">Buat akun NexLearn Anda secara gratis</p>
        </div>
        
        <!-- Form -->
        <form class="space-y-4 md:space-y-5" @submit.prevent="handleRegister">
          <!-- Full Name -->
          <div>
            <label class="block font-label-sm text-label-sm text-on-background mb-1" for="fullName">Nama Lengkap</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-outline">person</span>
              </div>
              <input v-model="form.name" class="input-field block w-full pl-10 pr-3 py-3 font-body-md text-body-md bg-surface-container-lowest text-on-background" id="fullName" placeholder="Masukkan nama lengkap" required type="text"/>
            </div>
          </div>
          
          <!-- Email -->
          <div>
            <label class="block font-label-sm text-label-sm text-on-background mb-1" for="email">Email</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-outline">mail</span>
              </div>
              <input v-model="form.email" class="input-field block w-full pl-10 pr-3 py-3 font-body-md text-body-md bg-surface-container-lowest text-on-background" id="email" placeholder="nama@email.com" required type="email"/>
            </div>
          </div>
          
          <!-- Password -->
          <div>
            <label class="block font-label-sm text-label-sm text-on-background mb-1" for="password">Kata Sandi</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-outline">lock</span>
              </div>
              <input v-model="form.password" class="input-field block w-full pl-10 pr-3 py-3 font-body-md text-body-md bg-surface-container-lowest text-on-background" id="password" placeholder="Minimal 8 karakter & 1 simbol" required :type="showPassword ? 'text' : 'password'"/>
              <button @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-on-background transition-colors focus:outline-none" type="button">
                <span class="material-symbols-outlined">{{ showPassword ? 'visibility' : 'visibility_off' }}</span>
              </button>
            </div>
            <p class="text-xs text-on-surface-variant mt-1 font-medium">Aturan: Min. 8 karakter & wajib ada 1 simbol (contoh: @, #, $, !)</p>
          </div>
          
          <!-- Confirm Password -->
          <div>
            <label class="block font-label-sm text-label-sm text-on-background mb-1" for="confirmPassword">Konfirmasi Kata Sandi</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-outline">swipe_left_alt</span>
              </div>
              <input v-model="form.password_confirmation" class="input-field block w-full pl-10 pr-3 py-3 font-body-md text-body-md bg-surface-container-lowest text-on-background" id="confirmPassword" placeholder="Ulangi kata sandi" required :type="showPassword ? 'text' : 'password'"/>
            </div>
          </div>
          
          <!-- Terms -->
          <div class="flex items-start mt-2">
            <div class="flex items-center h-5">
              <input v-model="form.terms" class="w-4 h-4 text-primary bg-surface-container-lowest border-outline-variant rounded focus:ring-primary focus:ring-2" id="terms" required type="checkbox"/>
            </div>
            <div class="ml-3 text-sm">
              <label class="font-body-md text-body-md text-on-surface-variant" for="terms">Saya setuju dengan <a class="text-primary hover:underline" href="#">Syarat &amp; Ketentuan</a> serta <a class="text-primary hover:underline" href="#">Kebijakan Privasi</a> NexLearn.</label>
            </div>
          </div>
          
          <!-- Submit Button -->
          <button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm font-label-sm text-label-sm font-semibold text-on-primary bg-primary hover:bg-on-background hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" type="submit">
            Daftar Sekarang
          </button>
        </form>
        
        <!-- Footer Link -->
        <div class="mt-6 text-center">
          <p class="font-body-md text-body-md text-on-surface-variant">
            Sudah punya akun? <router-link to="/login" class="text-primary font-semibold hover:underline">Masuk</router-link>
          </p>
        </div>
      </div>
    </main>
  </div>
</template>


<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { authApi } from '@/services/api';

const router = useRouter();
const showPassword = ref(false);

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false,
});

const toast = reactive({ show: false, message: '', type: 'success' });

const showToast = (msg, type = 'success') => {
  toast.message = msg;
  toast.type = type;
  toast.show = true;
  setTimeout(() => { toast.show = false; }, 3000);
};

const handleRegister = async () => {
  // Validasi di Frontend sebelum nyapa Satpam Backend
  if (form.password.length < 8) {
    return showToast('Kata sandi kekpendekan bro! Minimal 8 huruf/angka.', 'error');
  }
  
  const adaSimbol = /[!@#$%^&*(),.?":{}|<>\-_+=\/\[\]~]/.test(form.password);
  if (!adaSimbol) {
    return showToast('Kata sandinya harus ada simbolnya bro! (contoh: @, #, $, dll)', 'error');
  }

  if (form.password !== form.password_confirmation) {
    return showToast('Password yang kamu ketik ulang nggak sama bro.', 'error');
  }

  if (!form.terms) {
    return showToast('Kamu harus setuju sama Syarat & Ketentuan dulu.', 'error');
  }

  try {
    const response = await authApi.register({
      name: form.name,
      email: form.email,
      password: form.password,
      password_confirmation: form.password_confirmation
    });
    
    // Jangan langsung login, biarkan user login manual
    // localStorage.setItem('isLoggedIn', 'true'); 
    
    showToast(response.message, 'success');
    // Arahkan ke halaman login
    setTimeout(() => router.push('/login'), 2000);
    
  } catch (error) {
    let errorMsg = error.message;
    // Deteksi kalau Laravel ngasih halaman HTML (berarti user udah login atau session error)
    if (errorMsg.includes('Unexpected token')) {
      errorMsg = "Oops! Sepertinya kamu sudah login, atau sesi-mu bermasalah. Coba refresh halaman!";
    }
    showToast(errorMsg, 'error');
  }
};
</script>

<style scoped>
@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(30px, -50px) scale(1.1); }
  66% { transform: translate(-20px, 20px) scale(0.9); }
  100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob {
  animation: blob 7s infinite;
}
.animation-delay-2000 {
  animation-delay: 2s;
}
.animation-delay-4000 {
  animation-delay: 4s;
}
.input-field {
  border: 1px solid #c2c6d6;
  border-radius: 12px;
  transition: all 0.2s ease-in-out;
}
.input-field:focus {
  border-color: #191c1d;
  border-width: 2px;
  outline: none;
  box-shadow: none;
}

/* Animasi Toast */
.toast-fade-enter-active,
.toast-fade-leave-active {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.toast-fade-enter-from {
  opacity: 0;
  transform: translate(-50%, -20px);
}
.toast-fade-leave-to {
  opacity: 0;
  transform: translate(-50%, -20px);
}
</style>

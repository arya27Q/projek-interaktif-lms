<template>
  <div class="bg-pattern min-h-screen flex items-center justify-center p-4 md:p-8 font-body-md text-on-surface w-full">
    <!-- Suppress navigation shell as this is a transactional page (Login) -->
    <main class="w-full max-w-md bg-surface-container-lowest rounded-3xl shadow-[0px_20px_40px_rgba(0,0,0,0.08)] border border-surface-container-high p-6 md:p-8 flex flex-col items-center">
      <div class="mb-6 md:mb-8 text-center">
        <h1 class="font-headline-md text-headline-md text-primary mb-2">Selamat Datang Kembali</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">Masuk ke akun NexLearn Anda</p>
      </div>

      <form @submit.prevent="handleLogin" class="w-full flex flex-col gap-5 md:gap-6">
        <div class="flex flex-col gap-2">
          <label class="font-label-sm text-label-sm text-on-surface" for="email">Email</label>
          <div class="relative flex items-center">
            <span class="material-symbols-outlined absolute left-3 text-on-surface-variant">mail</span>
            <input v-model="form.email" class="w-full pl-10 pr-4 py-3 rounded-[12px] border border-outline-variant bg-surface-container-lowest text-on-surface focus:border-on-surface focus:ring-1 focus:ring-on-surface transition-colors outline-none font-body-md text-body-md placeholder-on-surface-variant/50" id="email" name="email" placeholder="nama@email.com" required type="email"/>
          </div>
        </div>

        <div class="flex flex-col gap-2">
          <div class="flex justify-between items-center">
            <label class="font-label-sm text-label-sm text-on-surface" for="password">Kata Sandi</label>
            <router-link to="/forgot-password" class="font-label-sm text-label-sm text-primary hover:text-primary-container transition-colors">Lupa Kata Sandi?</router-link>
          </div>
          <div class="relative flex items-center">
            <span class="material-symbols-outlined absolute left-3 text-on-surface-variant">lock</span>
            <input v-model="form.password" class="w-full pl-10 pr-10 py-3 rounded-[12px] border border-outline-variant bg-surface-container-lowest text-on-surface focus:border-on-surface focus:ring-1 focus:ring-on-surface transition-colors outline-none font-body-md text-body-md placeholder-on-surface-variant/50" id="password" name="password" placeholder="••••••••" required :type="showPassword ? 'text' : 'password'"/>
            <button @click="showPassword = !showPassword" aria-label="Tampilkan kata sandi" class="absolute right-3 text-on-surface-variant hover:text-on-surface transition-colors" type="button">
              <span class="material-symbols-outlined">{{ showPassword ? 'visibility' : 'visibility_off' }}</span>
            </button>
          </div>
        </div>

        <button class="w-full bg-primary text-on-primary font-label-sm text-label-sm py-3 rounded-full hover:bg-on-surface hover:-translate-y-0.5 transition-all duration-200 shadow-md" type="submit">
          Sign In
        </button>
      </form>

      <div class="w-full flex items-center gap-4 my-6">
        <div class="h-px bg-outline-variant flex-1"></div>
        <span class="font-label-sm text-label-sm text-on-surface-variant">atau masuk dengan</span>
        <div class="h-px bg-outline-variant flex-1"></div>
      </div>

      <div class="w-full flex flex-col gap-3">
        <button class="w-full bg-surface-container-low text-on-surface font-label-sm text-label-sm py-3 px-4 rounded-full border border-outline-variant hover:bg-surface-container transition-colors flex items-center justify-center gap-2" type="button">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.56 12.25C22.56 11.47 22.49 10.72 22.36 10H12V14.26H17.92C17.67 15.63 16.89 16.81 15.73 17.58V20.34H19.3C21.38 18.42 22.56 15.6 22.56 12.25Z" fill="#4285F4"></path>
            <path d="M12 23C14.97 23 17.46 22.02 19.3 20.34L15.73 17.58C14.74 18.25 13.48 18.66 12 18.66C9.14 18.66 6.71 16.73 5.84 14.14H2.15V16.99C3.96 20.6 7.69 23 12 23Z" fill="#34A853"></path>
            <path d="M5.84 14.14C5.62 13.47 5.49 12.76 5.49 12C5.49 11.24 5.61 10.53 5.84 9.86V7.01H2.15C1.4 8.5 1 10.19 1 12C1 13.81 1.4 15.5 2.15 16.99L5.84 14.14Z" fill="#FBBC05"></path>
            <path d="M12 5.34C13.62 5.34 15.07 5.9 16.21 6.99L19.39 3.8C17.45 2 14.97 1 12 1C7.69 1 3.96 3.4 2.15 7.01L5.84 9.86C6.71 7.27 9.14 5.34 12 5.34Z" fill="#EA4335"></path>
          </svg>
          Google
        </button>
        <button class="w-full bg-surface-container-low text-on-surface font-label-sm text-label-sm py-3 px-4 rounded-full border border-outline-variant hover:bg-surface-container transition-colors flex items-center justify-center gap-2" type="button">
          <svg class="w-5 h-5 text-on-surface" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12C2 16.42 4.867 20.166 8.833 21.488C9.333 21.579 9.52 21.272 9.52 21.008C9.52 20.77 9.511 19.99 9.506 19.123C6.724 19.727 6.137 17.973 6.137 17.973C5.682 16.818 5.029 16.51 5.029 16.51C4.126 15.892 5.097 15.904 5.097 15.904C6.096 15.974 6.621 16.93 6.621 16.93C7.508 18.45 8.948 18.01 9.539 17.755C9.629 17.086 9.899 16.647 10.198 16.398C7.976 16.145 5.642 15.285 5.642 11.472C5.642 10.386 6.031 9.497 6.666 8.795C6.564 8.542 6.223 7.531 6.764 6.155C6.764 6.155 7.599 5.888 9.502 7.175C10.297 6.953 11.15 6.843 12 6.839C12.85 6.843 13.704 6.953 14.499 7.175C16.401 5.888 17.235 6.155 17.235 6.155C17.777 7.531 17.437 8.542 17.335 8.795C17.972 9.497 18.359 10.386 18.359 11.472C18.359 15.295 16.023 16.142 13.795 16.388C14.169 16.711 14.502 17.348 14.502 18.312C14.502 19.693 14.49 20.808 14.49 21.008C14.49 21.275 14.674 21.585 15.178 21.487C19.141 20.163 22 16.418 22 12C22 6.477 17.523 2 12 2Z" fill-rule="evenodd"></path>
          </svg>
          GitHub
        </button>
      </div>

      <p class="mt-8 font-code text-code text-on-surface-variant text-center">
        Belum punya akun? <router-link to="/register" class="text-primary hover:underline">Daftar sekarang</router-link>
      </p>
    </main>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';

const showPassword = ref(false);

const form = reactive({
  email: '',
  password: '',
});

const handleLogin = () => {
  // TODO: Handle login logic
  console.log('Logging in...', form);
};
</script>

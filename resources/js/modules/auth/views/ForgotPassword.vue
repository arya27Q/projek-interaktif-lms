<template>
  <div class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-background text-on-background relative overflow-hidden w-full">
    
    <!-- Ambient Background Shapes -->
    <div class="ambient-shape-1"></div>
    <div class="ambient-shape-2"></div>
    
    <!-- Floating Card -->
    <main class="w-full max-w-110 bg-surface-container-lowest rounded-3xl shadow-[0px_20px_40px_rgba(0,0,0,0.08)] p-8 md:p-10 relative z-10 flex flex-col items-center">
      
      <!-- Logo Area -->
      <div class="mb-6 md:mb-8 flex flex-col items-center">
        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center mb-4 shadow-[0px_10px_30px_rgba(0,0,0,0.04)]">
          <span class="material-symbols-outlined text-on-primary text-2xl font-bold" data-icon="school" style="font-variation-settings: 'FILL' 1;">school</span>
        </div>
        <h1 class="font-headline-md text-headline-md text-primary font-bold">NexLearn</h1>
      </div>
      
      <!-- Copy -->
      <div class="text-center w-full mb-6 md:mb-8">
        <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Lupa Password?</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">Kami akan membantu Anda masuk kembali. Masukkan email Anda untuk menerima instruksi reset password.</p>
      </div>
      
      <!-- Form -->
      <form @submit.prevent="handleForgotPassword" class="w-full flex flex-col gap-5 md:gap-6">
        <div class="w-full">
          <label class="sr-only" for="email">Email</label>
          <div class="relative group focus-within:-translate-y-px focus-within:shadow-[0_4px_12px_rgba(0,0,0,0.05)] transition-all duration-200 rounded-xl">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-on-surface transition-colors duration-200" data-icon="mail">mail</span>
            <input v-model="email" class="w-full pl-12 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-md text-body-md text-on-surface placeholder-outline focus:border-on-surface focus:ring-1 focus:ring-on-surface transition-all duration-200 hover:border-outline outline-none" id="email" name="email" placeholder="Alamat Email" required type="email"/>
          </div>
        </div>
        
        <button class="w-full py-3 px-6 bg-primary text-on-primary rounded-xl font-label-sm text-label-sm hover:bg-on-surface hover:-translate-y-0.5 transition-all duration-300 shadow-md flex items-center justify-center gap-2 group" type="submit">
          Kirim Instruksi
          <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform duration-200" data-icon="arrow_forward">arrow_forward</span>
        </button>
      </form>
      
      <!-- Back to Login -->
      <div class="mt-8 text-center w-full">
        <router-link to="/login" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary font-label-sm text-label-sm transition-colors duration-200 group">
          <span class="material-symbols-outlined text-[16px] group-hover:-translate-x-1 transition-transform duration-200" data-icon="arrow_back">arrow_back</span>
          Kembali ke Login
        </router-link>
      </div>
      
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const email = ref('');

const handleForgotPassword = () => {
  // TODO: Handle password reset logic
  console.log('Requesting password reset for:', email.value);
};
</script>

<style scoped>
/* Minimal ambient background shapes to reinforce the academic/clean style */
.ambient-shape-1 {
  position: absolute;
  top: -100px;
  left: -100px;
  width: 300px;
  height: 300px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(33,112,228,0.05) 0%, rgba(248,249,250,0) 70%); /* primary-container */
  z-index: 0;
  pointer-events: none;
}

.ambient-shape-2 {
  position: absolute;
  bottom: -150px;
  right: -50px;
  width: 400px;
  height: 400px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(33,112,228,0.03) 0%, rgba(248,249,250,0) 70%);
  z-index: 0;
  pointer-events: none;
}
</style>

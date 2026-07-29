<template>
  <div v-if="show" class="fixed inset-0 z-100 flex items-center justify-center p-4">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="$emit('close')"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-surface rounded-3xl shadow-[0px_20px_40px_rgba(0,0,0,0.2)] w-full max-w-md flex flex-col max-h-[90vh] overflow-hidden animate-in zoom-in-95 duration-200">
      <div class="flex items-center justify-between p-4 border-b border-surface-container bg-surface z-10">
        <h3 class="font-headline-sm text-on-surface">Potong Foto</h3>
        <button @click="$emit('close')" class="p-2 text-on-surface-variant hover:bg-surface-container rounded-full transition-colors flex items-center justify-center">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      
      <div class="relative flex-grow h-[400px] flex items-center justify-center bg-surface-container-lowest overflow-hidden">
        <img ref="imageRef" :src="imageUrl" class="max-w-full max-h-full" style="display: block; max-width: 100%;" />
      </div>
      
      <div class="p-4 border-t border-surface-container bg-surface flex justify-end gap-3 z-10">
        <button @click="$emit('close')" class="px-6 py-2.5 text-secondary font-label-sm rounded-xl hover:bg-surface-container transition-colors">
          Batal
        </button>
        <button @click="handleCrop" class="px-6 py-2.5 bg-primary text-on-primary font-label-sm rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all">
          Terapkan
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onUnmounted, watch, nextTick } from 'vue';
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';

const props = defineProps({
  show: Boolean,
  imageUrl: String
});

const emit = defineEmits(['close', 'crop']);

const imageRef = ref(null);
let cropper = null;

watch(() => props.show, async (newVal) => {
  if (newVal) {
    await nextTick();
    if (imageRef.value) {
      // Tunggu sedikit agar gambar dirender sepenuhnya sebelum inisialisasi cropper
      setTimeout(() => {
        cropper = new Cropper(imageRef.value, {
          aspectRatio: 1, // Persegi 1:1
          viewMode: 1, // Batasi cropper dalam area gambar
          dragMode: 'move', // Default drag adalah menggeser gambar
          autoCropArea: 0.8,
          restore: false,
          guides: true,
          center: true,
          highlight: false,
          cropBoxMovable: true,
          cropBoxResizable: true,
          toggleDragModeOnDblclick: true,
        });
      }, 50);
    }
  } else {
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }
  }
});

onUnmounted(() => {
  if (cropper) {
    cropper.destroy();
  }
});

const handleCrop = () => {
  if (!cropper) return;
  
  // Dapatkan hasil potong dengan ukuran max 500x500px
  const canvas = cropper.getCroppedCanvas({
    width: 500,
    height: 500,
    imageSmoothingEnabled: true,
    imageSmoothingQuality: 'high',
  });
  
  // Konversi jadi base64 JPEG agar lebih kecil sizenya
  const base64Url = canvas.toDataURL('image/jpeg', 0.85);
  emit('crop', base64Url);
};
</script>

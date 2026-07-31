<template>
  <div class="max-w-4xl mx-auto pb-20">
    <div class="flex items-center gap-4 mb-8">
      <router-link to="/instructor" class="p-2 bg-surface-container-low hover:bg-surface-container-high rounded-lg transition-colors">
        <span class="material-symbols-outlined">arrow_back</span>
      </router-link>
      <div>
        <h2 class="font-headline-md text-headline-md text-on-surface">
          {{ isEditing ? 'Edit Kursus' : 'Buat Kursus Baru' }}
        </h2>
        <p class="text-secondary font-body-md">Lengkapi detail kursus dan materi pelajaran kamu di sini.</p>
      </div>
    </div>

    <!-- Tab Navigation -->
    <div class="flex gap-4 border-b border-surface-container-high mb-8">
      <button 
        @click="activeTab = 'details'"
        class="pb-3 font-label-md px-2 border-b-2 transition-colors"
        :class="activeTab === 'details' ? 'border-primary text-primary' : 'border-transparent text-secondary hover:text-on-surface'"
      >
        Detail Kursus
      </button>
      <button 
        v-if="isEditing"
        @click="activeTab = 'curriculum'"
        class="pb-3 font-label-md px-2 border-b-2 transition-colors"
        :class="activeTab === 'curriculum' ? 'border-primary text-primary' : 'border-transparent text-secondary hover:text-on-surface'"
      >
        Kurikulum & Materi
      </button>
    </div>

    <!-- DETAIL KURSUS -->
    <div v-if="activeTab === 'details'" class="glass-card p-8 rounded-xl space-y-6">
      <div>
        <label class="block text-label-sm font-bold text-on-surface mb-2">Judul Kursus</label>
        <input v-model="course.title" type="text" placeholder="Misal: Mastering Vue 3 & Tailwind" class="w-full bg-surface-container-lowest border border-surface-container-high rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary transition-colors">
      </div>
      <div class="grid grid-cols-2 gap-6">
        <div>
          <label class="block text-label-sm font-bold text-on-surface mb-2">Kategori</label>
          <select v-model="course.category" class="w-full bg-surface-container-lowest border border-surface-container-high rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary transition-colors">
            <option value="Pemrograman">Pemrograman</option>
            <option value="Desain">Desain</option>
            <option value="Bisnis">Bisnis</option>
          </select>
        </div>
        <div>
          <label class="block text-label-sm font-bold text-on-surface mb-2">Level</label>
          <select v-model="course.level" class="w-full bg-surface-container-lowest border border-surface-container-high rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary transition-colors">
            <option value="beginner">Pemula (Beginner)</option>
            <option value="intermediate">Menengah (Intermediate)</option>
            <option value="advanced">Lanjutan (Advanced)</option>
          </select>
        </div>
      </div>
      <div>
        <label class="block text-label-sm font-bold text-on-surface mb-2">Harga (Rp)</label>
        <input v-model="course.price" type="number" placeholder="Misal: 150000 (0 untuk gratis)" class="w-full bg-surface-container-lowest border border-surface-container-high rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary transition-colors">
      </div>
      <div>
        <label class="block text-label-sm font-bold text-on-surface mb-2">Upload Thumbnail</label>
        <input type="file" accept="image/jpeg,image/png,image/jpg" @change="handleThumbnailUpload" ref="fileInput" class="w-full bg-surface-container-lowest border border-surface-container-high rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary transition-colors">
        
        <!-- Preview & Cropper -->
        <div v-if="imageUrl" class="mt-4 border border-surface-container-high rounded-lg p-4 bg-surface-container-lowest">
          <div v-if="!isCropped" class="mb-4">
            <p class="text-sm font-bold mb-2">Pilih Area Gambar (Crop)</p>
            <div class="h-64 bg-surface-container-low overflow-hidden rounded-lg">
              <img ref="imageElement" :src="imageUrl" class="max-w-full block" alt="Image to crop">
            </div>
            <div class="mt-4 flex justify-end gap-2">
               <button @click="cancelCrop" class="px-4 py-2 bg-surface-container-highest rounded-lg text-sm font-bold hover:bg-surface-container-low transition-colors">Batal</button>
               <button @click="doCrop" class="px-4 py-2 bg-primary text-on-primary rounded-lg text-sm font-bold hover:bg-on-surface transition-colors">Potong (Crop)</button>
            </div>
          </div>
          <div v-else class="flex flex-col items-center">
            <p class="text-sm font-bold mb-2 w-full text-left">Hasil Thumbnail</p>
            <img :src="croppedImageUrl" class="max-h-48 rounded-lg border border-surface-container-high shadow-md" alt="Cropped preview">
            <button @click="resetCrop" class="mt-3 text-sm text-primary font-bold hover:underline">Ganti Gambar / Crop Ulang</button>
          </div>
        </div>
        <div v-else-if="isEditing && course.thumbnail_url" class="mt-4">
          <p class="text-sm font-bold mb-2">Thumbnail Saat Ini</p>
          <img :src="course.thumbnail_url" class="max-h-48 rounded-lg border border-surface-container-high shadow-md" alt="Current thumbnail">
        </div>
        <p v-else class="text-[10px] text-secondary mt-1">Format: JPG, PNG (Max 2MB)</p>
      </div>
      <div>
        <label class="block text-label-sm font-bold text-on-surface mb-2">Deskripsi</label>
        <textarea v-model="course.description" rows="5" placeholder="Ceritakan apa yang akan dipelajari di kursus ini..." class="w-full bg-surface-container-lowest border border-surface-container-high rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary transition-colors"></textarea>
      </div>
      
      <div class="pt-4 border-t border-surface-container-high flex justify-end gap-3">
        <button v-if="isEditing && course.status === 'draft'" @click="publishCourse" :disabled="isPublishing" class="flex items-center gap-2 px-6 py-3 bg-tertiary text-on-tertiary rounded-lg font-label-md hover:bg-tertiary-fixed-dim transition-colors disabled:opacity-50">
          <span v-if="isPublishing" class="material-symbols-outlined animate-spin">progress_activity</span>
          <span v-else class="material-symbols-outlined">rocket_launch</span>
          {{ isPublishing ? 'Menerbitkan...' : 'Terbitkan Kursus' }}
        </button>
        <button @click="saveCourse" :disabled="isSaving" class="flex items-center gap-2 px-6 py-3 bg-primary text-on-primary rounded-lg font-label-md hover:bg-on-surface transition-colors disabled:opacity-50">
          <span v-if="isSaving" class="material-symbols-outlined animate-spin">progress_activity</span>
          <span v-else class="material-symbols-outlined">save</span>
          {{ isSaving ? 'Menyimpan...' : 'Simpan Detail' }}
        </button>
      </div>
    </div>

    <!-- KURIKULUM & MATERI -->
    <div v-if="activeTab === 'curriculum'" class="space-y-6">
      
      <div v-for="(module, mIndex) in course.modules" :key="module.id" class="glass-card p-6 rounded-xl border-l-4 border-l-primary">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-title-md font-bold">Modul {{ mIndex + 1 }}: {{ module.title }}</h3>
          <button class="text-secondary hover:text-error transition-colors"><span class="material-symbols-outlined">delete</span></button>
        </div>

        <!-- Lessons -->
        <div class="space-y-3 mb-6 pl-4 border-l-2 border-surface-container-high">
          <div v-for="(lesson, lIndex) in module.lessons" :key="lesson.id" class="p-3 bg-surface-container-lowest rounded-lg border border-surface-container-high flex justify-between items-center">
            <div class="flex items-center gap-3">
              <span class="material-symbols-outlined text-secondary" v-if="lesson.type === 'video'">play_circle</span>
              <span class="material-symbols-outlined text-secondary" v-else>article</span>
              <span>{{ lIndex + 1 }}. {{ lesson.title }}</span>
            </div>
            <div class="flex items-center gap-2 text-sm text-secondary">
              <a v-if="lesson.media_url" :href="lesson.media_url" target="_blank" class="hover:text-primary">Lihat Media</a>
            </div>
          </div>
          
          <div v-if="!module.lessons || module.lessons.length === 0" class="text-sm text-secondary italic py-2">Belum ada pelajaran di modul ini.</div>
        </div>

        <!-- Form Tambah Lesson -->
        <div class="bg-surface-container-lowest p-4 rounded-lg border border-dashed border-primary">
          <h4 class="font-label-sm font-bold text-primary mb-3">Tambah Pelajaran Baru</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <input v-model="newLesson[module.id].title" type="text" placeholder="Judul Video / Materi" class="w-full bg-surface-container-lowest border border-surface-container-high rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary transition-colors">
            
            <div class="flex items-center gap-2">
              <select v-model="newLesson[module.id].type" class="bg-surface-container-lowest border border-surface-container-high rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary transition-colors">
                <option value="video">Video URL (YouTube/Drive)</option>
                <option value="upload">Upload File Video Lokal (MP4)</option>
              </select>
            </div>
          </div>
          
          <div v-if="newLesson[module.id].type === 'video'" class="mb-4">
             <input v-model="newLesson[module.id].media_url" type="text" placeholder="URL Video (Misal: https://youtube.com/...)" class="w-full bg-surface-container-lowest border border-surface-container-high rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary transition-colors">
          </div>
          
          <div v-if="newLesson[module.id].type === 'upload'" class="mb-4">
             <input type="file" accept="video/mp4,video/webm" @change="e => handleFileUpload(e, module.id)" class="w-full bg-surface-container-lowest border border-surface-container-high rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary transition-colors">
             <p class="text-[10px] text-secondary mt-1">Format: MP4, WebM (Max 500MB)</p>
          </div>

          <div class="flex justify-end">
            <button @click="saveLesson(module.id)" :disabled="isSavingLesson" class="px-4 py-2 bg-primary-fixed text-primary rounded-lg text-sm font-bold hover:bg-primary hover:text-on-primary transition-colors flex items-center gap-2">
              <span v-if="isSavingLesson" class="material-symbols-outlined text-[16px] animate-spin">progress_activity</span>
              <span v-else class="material-symbols-outlined text-[16px]">add</span>
              Tambah
            </button>
          </div>
        </div>
      </div>

      <!-- Form Tambah Module -->
      <div class="glass-card p-6 rounded-xl border border-dashed border-surface-container-highest flex items-center gap-4">
        <input v-model="newModuleTitle" type="text" placeholder="Ketik judul Modul baru..." class="flex-1 bg-surface-container-lowest border border-surface-container-high rounded-lg px-4 py-3 text-body-md focus:outline-none focus:border-primary transition-colors">
        <button @click="saveModule" :disabled="isSavingModule || !newModuleTitle" class="px-6 py-3 bg-secondary text-on-primary rounded-lg font-label-md hover:bg-on-surface transition-colors disabled:opacity-50">
          Buat Modul
        </button>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, reactive, nextTick } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Swal from 'sweetalert2';
import axios from 'axios';
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';

const route = useRoute();
const router = useRouter();

const isEditing = ref(false);
const activeTab = ref('details');
const courseId = ref(route.params.id);

const isSaving = ref(false);
const isPublishing = ref(false);
const isSavingModule = ref(false);
const isSavingLesson = ref(false);

const course = ref({
  title: '',
  category: 'Pemrograman',
  level: 'beginner',
  price: 0,
  description: '',
  thumbnail_file: null,
  modules: []
});

const newModuleTitle = ref('');

// Cropper state
const imageElement = ref(null);
const fileInput = ref(null);
const imageUrl = ref(null);
const croppedImageUrl = ref(null);
const isCropped = ref(false);
let cropper = null;

const handleThumbnailUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      imageUrl.value = e.target.result;
      isCropped.value = false;
      croppedImageUrl.value = null;
      course.value.thumbnail_file = null;
      
      nextTick(() => {
        if (cropper) cropper.destroy();
        if (imageElement.value) {
          cropper = new Cropper(imageElement.value, {
            aspectRatio: 16 / 9,
            viewMode: 1,
            autoCropArea: 1,
          });
        }
      });
    };
    reader.readAsDataURL(file);
  }
};

const doCrop = () => {
  if (!cropper) return;
  const canvas = cropper.getCroppedCanvas({
    width: 800,
    height: 450,
  });
  
  croppedImageUrl.value = canvas.toDataURL('image/jpeg');
  
  canvas.toBlob((blob) => {
    const file = new File([blob], "thumbnail.jpg", { type: "image/jpeg" });
    course.value.thumbnail_file = file;
    isCropped.value = true;
    cropper.destroy();
    cropper = null;
  }, 'image/jpeg', 0.85);
};

const cancelCrop = () => {
  if (cropper) {
    cropper.destroy();
    cropper = null;
  }
  imageUrl.value = null;
  if (fileInput.value) fileInput.value.value = '';
};

const resetCrop = () => {
  imageUrl.value = null;
  isCropped.value = false;
  croppedImageUrl.value = null;
  course.value.thumbnail_file = null;
  if (fileInput.value) fileInput.value.value = '';
};

// State untuk menyimpan draft lesson di tiap module id
const newLesson = reactive({});

onMounted(async () => {
  if (courseId.value && courseId.value !== 'new') {
    isEditing.value = true;
    await fetchCourse();
  }
});

const fetchCourse = async () => {
  try {
    const res = await axios.get(`/instructor/courses/${courseId.value}`);
    course.value = res.data;
    
    // Inisialisasi draft lesson untuk tiap modul
    course.value.modules.forEach(m => {
      if(!newLesson[m.id]) {
        newLesson[m.id] = { title: '', type: 'video', media_url: '', video_file: null };
      }
    });
  } catch (error) {
    console.error(error);
  }
};

const saveCourse = async () => {
  isSaving.value = true;
  try {
    const url = `/instructor/courses${isEditing.value ? '/' + courseId.value : ''}`;
    
    const formData = new FormData();
    formData.append('title', course.value.title);
    formData.append('category', course.value.category);
    formData.append('level', course.value.level);
    formData.append('price', course.value.price || 0);
    formData.append('description', course.value.description || '');
    if (course.value.thumbnail_file) {
      formData.append('thumbnail', course.value.thumbnail_file);
    }

    const res = await axios.post(url, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });
    
    Swal.fire({
      title: 'Berhasil!', 
      text: 'Detail kursus berhasil disimpan', 
      icon: 'success',
      background: '#16a34a',
      color: '#fff',
      customClass: { popup: 'rounded-2xl' }
    });
    
    if (!isEditing.value) {
      router.push(`/instructor/course/${res.data.data.id}/edit`);
    }
  } catch (error) {
    Swal.fire({
      title: 'Error', 
      text: 'Gagal menyimpan', 
      icon: 'error',
      background: '#dc2626',
      color: '#fff',
      customClass: { popup: 'rounded-2xl' }
    });
  } finally {
    isSaving.value = false;
  }
};

const publishCourse = async () => {
  isPublishing.value = true;
  try {
    const res = await axios.post(`/instructor/courses/${courseId.value}/publish`);
    
    course.value.status = 'published';
    Swal.fire({
      title: 'Berhasil Diterbitkan!', 
      text: 'Kursus kamu sekarang bisa dilihat oleh semua orang di Katalog.', 
      icon: 'success',
      background: '#16a34a',
      color: '#fff',
      customClass: { popup: 'rounded-2xl' }
    });
  } catch (error) {
    Swal.fire({
      title: 'Error', 
      text: 'Gagal menerbitkan kursus', 
      icon: 'error',
      background: '#dc2626',
      color: '#fff',
      customClass: { popup: 'rounded-2xl' }
    });
  } finally {
    isPublishing.value = false;
  }
};

const saveModule = async () => {
  isSavingModule.value = true;
  try {
    const res = await axios.post(`/instructor/courses/${courseId.value}/modules`, {
      title: newModuleTitle.value
    });
    
    course.value.modules.push({...res.data.data, lessons: []});
    newLesson[res.data.data.id] = { title: '', type: 'video', media_url: '', video_file: null };
    newModuleTitle.value = '';
    
    Swal.fire({
      title: 'Berhasil!', 
      text: 'Modul ditambahkan', 
      icon: 'success',
      background: '#16a34a',
      color: '#fff',
      customClass: { popup: 'rounded-2xl' }
    });
  } catch (error) {
    Swal.fire({
      title: 'Error', 
      text: 'Gagal menambah modul', 
      icon: 'error',
      background: '#dc2626',
      color: '#fff',
      customClass: { popup: 'rounded-2xl' }
    });
  } finally {
    isSavingModule.value = false;
  }
};

const handleFileUpload = (event, moduleId) => {
  const file = event.target.files[0];
  if (file) {
    newLesson[moduleId].video_file = file;
  }
};

const saveLesson = async (moduleId) => {
  const lessonData = newLesson[moduleId];
  if (!lessonData.title) return Swal.fire({ title: 'Oops', text: 'Judul materi harus diisi', icon: 'warning', background: '#eab308', color: '#fff', customClass: { popup: 'rounded-2xl' } });
  
  isSavingLesson.value = true;
  try {
    const formData = new FormData();
    formData.append('title', lessonData.title);
    
    if (lessonData.type === 'upload') {
      formData.append('type', 'video');
      if (lessonData.video_file) {
        formData.append('video_file', lessonData.video_file);
      }
    } else {
      formData.append('type', lessonData.type);
      formData.append('media_url', lessonData.media_url);
    }
    
    const res = await axios.post(`/instructor/modules/${moduleId}/lessons`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    
    const mod = course.value.modules.find(m => m.id === moduleId);
    mod.lessons.push(res.data.data);
    
    // Reset form
    newLesson[moduleId] = { title: '', type: 'video', media_url: '', video_file: null };
    
    Swal.fire({
      title: 'Berhasil!', 
      text: 'Materi berhasil diunggah', 
      icon: 'success',
      background: '#16a34a',
      color: '#fff',
      customClass: { popup: 'rounded-2xl' }
    });
  } catch (error) {
    Swal.fire({
      title: 'Error', 
      text: 'Gagal menambah materi. Cek koneksi atau ukuran file.', 
      icon: 'error',
      background: '#dc2626',
      color: '#fff',
      customClass: { popup: 'rounded-2xl' }
    });
  } finally {
    isSavingLesson.value = false;
  }
};

</script>

<style scoped>
.glass-card {
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(243, 244, 246, 1);
}
</style>

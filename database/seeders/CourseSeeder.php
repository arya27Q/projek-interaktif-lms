<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Academic\Course;
use App\Models\Academic\Module;
use App\Models\Academic\Lesson;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan kita menggunakan course ID = 1 yang sudah kita buat
        $course = Course::find(1);
        
        if (!$course) {
            // Jika belum ada, buat dummy course baru
            $course = Course::create([
                'instructor_id' => 1,
                'title' => 'Mastering Vue 3 & Midtrans',
                'slug' => 'vue-midtrans-' . time(),
                'description' => 'Belajar Vue dan Midtrans',
                'price' => 250000,
                'status' => 'published',
                'category' => 'Web Development',
                'level' => 'intermediate'
            ]);
        }

        // Hapus modul lama jika ada (untuk testing agar fresh)
        $course->modules()->delete();

        // Modul 1
        $module1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Pengenalan Sistem Pembayaran',
            'order_index' => 1,
        ]);

        Lesson::create([
            'module_id' => $module1->id,
            'title' => 'Konsep Dasar Midtrans',
            'type' => 'video',
            'media_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            'order_index' => 1,
        ]);

        Lesson::create([
            'module_id' => $module1->id,
            'title' => 'Setup Environment Lokal',
            'type' => 'video',
            'media_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            'order_index' => 2,
        ]);

        // Modul 2
        $module2 = Module::create([
            'course_id' => $course->id,
            'title' => 'Implementasi Vue 3',
            'order_index' => 2,
        ]);

        Lesson::create([
            'module_id' => $module2->id,
            'title' => 'Membuat Komponen Checkout',
            'type' => 'video',
            'media_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            'order_index' => 1,
        ]);
        
        Lesson::create([
            'module_id' => $module2->id,
            'title' => 'Mengirim Token Snap',
            'type' => 'video',
            'media_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            'order_index' => 2,
        ]);
    }
}

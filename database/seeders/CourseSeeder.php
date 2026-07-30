<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // 1. Create a mock course
        $course = Course::create([
            'instructor_id' => 1,
            'title' => 'Mastering Vue & Laravel',
            'category' => 'Pemrograman',
            'level' => 'intermediate',
            'thumbnail_url' => 'https://via.placeholder.com/600x400.png?text=Vue+Laravel',
            'price' => 299000,
            'average_rating' => 4.8,
            'status' => 'published',
            'slug' => 'mastering-vue-laravel',
            'description' => 'Pelajari cara membangun aplikasi modern dengan Vue 3 dan Laravel 11.'
        ]);

        // 2. Create modules
        $module1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Pengenalan & Setup',
            'order_index' => 1,
        ]);

        $module2 = Module::create([
            'course_id' => $course->id,
            'title' => 'Membuat API dengan Laravel',
            'order_index' => 2,
        ]);

        // 3. Create lessons
        Lesson::create([
            'module_id' => $module1->id,
            'title' => 'Instalasi Laravel 11',
            'type' => 'video',
            'media_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            'order_index' => 1
        ]);
        
        Lesson::create([
            'module_id' => $module1->id,
            'title' => 'Instalasi Vue 3 & Vite',
            'type' => 'video',
            'media_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            'order_index' => 2
        ]);
        
        Lesson::create([
            'module_id' => $module2->id,
            'title' => 'Routing & Controller',
            'type' => 'video',
            'media_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            'order_index' => 1
        ]);
    }
}

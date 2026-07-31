<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Academic\Course;
use App\Models\Academic\Module;
use App\Models\Academic\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InstructorController extends Controller
{
    public function getCourses()
    {
        $courses = Course::withCount('modules')
            ->where('instructor_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($courses);
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'level' => 'required|string',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $thumbnailUrl = 'https://via.placeholder.com/600x400.png?text=' . urlencode($request->title);
        
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $thumbnailUrl = '/storage/' . $path;
        }

        $course = Course::create([
            'instructor_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'category' => $request->category,
            'level' => $request->level,
            'price' => $request->price ?? 0,
            'description' => $request->description,
            'status' => 'draft',
            'thumbnail_url' => $thumbnailUrl
        ]);

        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }

    public function updateCourse(Request $request, string $id)
    {
        $course = Course::query()->where('instructor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'level' => 'required|string',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $course->thumbnail_url = '/storage/' . $path;
        }

        $course->update([
            'title' => $request->title,
            'category' => $request->category,
            'level' => $request->level,
            'price' => $request->price ?? 0,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }

    public function publishCourse(string $id)
    {
        $course = Course::query()->where('instructor_id', Auth::id())->findOrFail($id);
        
        $course->update(['status' => 'published']);

        return response()->json([
            'success' => true,
            'message' => 'Kursus berhasil diterbitkan!'
        ]);
    }

    public function getCourseDetails(string $id)
    {
        $course = Course::with(['modules.lessons'])->where('instructor_id', Auth::id())->findOrFail($id);
        return response()->json($course);
    }

    public function storeModule(Request $request, string $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $orderIndex = Module::query()->where('course_id', $courseId)->max('order_index') + 1;

        $module = Module::create([
            'course_id' => $courseId,
            'title' => $request->title,
            'order_index' => $orderIndex
        ]);

        return response()->json(['success' => true, 'data' => $module]);
    }

    public function storeLesson(Request $request, string $moduleId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,quiz,text',
            'media_url' => 'nullable|string',
            'video_file' => 'nullable|file|mimes:mp4,webm|max:500000', // 500MB max
        ]);

        $mediaUrl = $request->media_url;

        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('videos', 'public');
            $mediaUrl = '/storage/' . $path;
        }

        $orderIndex = Lesson::query()->where('module_id', $moduleId)->max('order_index') + 1;

        $lesson = Lesson::create([
            'module_id' => $moduleId,
            'title' => $request->title,
            'type' => $request->type,
            'media_url' => $mediaUrl,
            'order_index' => $orderIndex
        ]);

        return response()->json(['success' => true, 'data' => $lesson]);
    }
}

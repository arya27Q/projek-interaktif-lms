<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Academic\Course;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $courses = Course::with('instructor')
            ->category($category)
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->where('status', 'published')
            ->paginate(6);

        return response()->json($courses);
    }

    public function show($id)
    {
        $course = Course::with(['instructor', 'modules.lessons'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }
}

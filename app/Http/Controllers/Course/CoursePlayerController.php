<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Academic\Course;
use App\Models\Academic\Note;
use Illuminate\Support\Facades\Auth;

class CoursePlayerController extends Controller
{
    public function getContent($id)
    {
        $course = Course::with(['modules.lessons'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }

    public function getNotes($lessonId)
    {
        $notes = Note::where('user_id', Auth::id())
            ->where('lesson_id', $lessonId)
            ->orderBy('video_timestamp', 'desc')
            ->get();
            
        return response()->json($notes);
    }

    public function saveNote(Request $request, $lessonId)
    {
        $request->validate([
            'text' => 'required|string',
            'video_timestamp' => 'required|integer'
        ]);

        $note = Note::create([
            'user_id' => Auth::id(),
            'lesson_id' => $lessonId,
            'video_timestamp' => $request->video_timestamp,
            'text' => $request->text,
        ]);

        return response()->json([
            'success' => true,
            'data' => $note
        ]);
    }
}

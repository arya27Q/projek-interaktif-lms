<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Academic\Course;
use App\Models\Academic\Note;
use App\Models\User\VideoWatchLog;
use App\Models\User\UserBookmark;
use App\Models\User\Discussion;
use App\Models\User\QuizAttempt;
use Illuminate\Support\Facades\Auth;

class CoursePlayerController extends Controller
{
    public function getContent($id)
    {
        $course = Course::with(['modules' => function ($query) {
            $query->orderBy('order_index');
        }, 'modules.lessons' => function ($query) {
            $query->orderBy('order_index');
        }])->findOrFail($id);
        
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

    public function updateProgress(Request $request, $lessonId)
    {
        $request->validate([
            'progress_seconds' => 'required|integer',
            'is_completed' => 'required|boolean'
        ]);

        $log = VideoWatchLog::updateOrCreate(
            ['user_id' => Auth::id(), 'lesson_id' => $lessonId],
            [
                'progress_seconds' => $request->progress_seconds,
                'is_completed' => $request->is_completed
            ]
        );

        return response()->json(['success' => true, 'data' => $log]);
    }

    public function toggleBookmark(Request $request, $lessonId)
    {
        $bookmark = UserBookmark::where('user_id', Auth::id())
            ->where('lesson_id', $lessonId)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['success' => true, 'bookmarked' => false]);
        } else {
            UserBookmark::create([
                'user_id' => Auth::id(),
                'lesson_id' => $lessonId,
                'timestamp' => $request->input('timestamp', 0)
            ]);
            return response()->json(['success' => true, 'bookmarked' => true]);
        }
    }

    public function getDiscussions($lessonId)
    {
        $discussions = Discussion::with('user')
            ->where('lesson_id', $lessonId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json(['success' => true, 'data' => $discussions]);
    }

    public function postDiscussion(Request $request, $lessonId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $discussion = Discussion::create([
            'user_id' => Auth::id(),
            'lesson_id' => $lessonId,
            'course_id' => \App\Models\Academic\Lesson::findOrFail($lessonId)->module->course_id,
            'content' => $request->content
        ]);

        return response()->json(['success' => true, 'data' => $discussion->load('user')]);
    }

    public function submitQuiz(Request $request, $lessonId)
    {
        $request->validate([
            'score' => 'required|numeric'
        ]);

        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'lesson_id' => $lessonId,
            'score' => $request->score,
            'is_passed' => $request->score >= 70
        ]);

        return response()->json(['success' => true, 'data' => $attempt]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Fetch conversation for a course.
     */
    public function index(Request $request, $course_id)
    {
        $course = Course::findOrFail($course_id);
        $user = Auth::user();

        // Ensure user belongs to course
        if ($user->role === 'student') {
            if (!$user->enrolledCourses()->where('courses.id', $course_id)->exists()) {
                return response()->json(['error' => 'Not enrolled in this course'], 403);
            }
            $targetUserId = $course->teacher_id;
        } else {
            if ($course->teacher_id !== $user->id) {
                return response()->json(['error' => 'Not the teacher of this course'], 403);
            }
            $targetUserId = $request->query('student_id');

            // If teacher doesn't provide a student_id, return a list of students who have messaged them in this course
            if (!$targetUserId) {
                $studentIds = Message::where('course_id', $course_id)
                    ->where(function ($query) use ($user) {
                        $query->where('receiver_id', $user->id)
                              ->orWhere('sender_id', $user->id);
                    })
                    ->select('sender_id', 'receiver_id')
                    ->get()
                    ->flatMap(function ($msg) use ($user) {
                        return [$msg->sender_id, $msg->receiver_id];
                    })
                    ->reject(fn($id) => $id === $user->id)
                    ->unique();

                // Get full list of enrolled students as well
                $enrolledStudents = $course->students()->get();

                $students = User::whereIn('id', $studentIds->merge($enrolledStudents->pluck('id'))->unique())->get();
                return response()->json(['students' => $students]);
            }
        }

        $messages = Message::with(['sender:id,name,profile_image'])
            ->where('course_id', $course_id)
            ->where(function ($query) use ($user, $targetUserId) {
                $query->where(function ($q) use ($user, $targetUserId) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $targetUserId);
                })->orWhere(function ($q) use ($user, $targetUserId) {
                    $q->where('sender_id', $targetUserId)
                      ->where('receiver_id', $user->id);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['messages' => $messages, 'targetUserId' => $targetUserId]);
    }

    /**
     * Send a message.
     */
    public function store(Request $request, $course_id)
    {
        $request->validate([
            'message_text' => 'required|string|max:1000'
        ]);

        $course = Course::findOrFail($course_id);
        $user = Auth::user();

        $receiverId = null;

        if ($user->role === 'student') {
            if (!$user->enrolledCourses()->where('courses.id', $course_id)->exists()) {
                return response()->json(['error' => 'Not enrolled in this course'], 403);
            }
            $receiverId = $course->teacher_id;
        } else {
            if ($course->teacher_id !== $user->id) {
                return response()->json(['error' => 'Not the teacher of this course'], 403);
            }
            $request->validate(['receiver_id' => 'required|exists:users,id']);
            $receiverId = $request->receiver_id;
        }

        $message = Message::create([
            'course_id' => $course_id,
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'message_text' => $request->message_text,
            'seen_status' => false
        ]);

        return response()->json(['message' => $message->load('sender:id,name,profile_image')], 201);
    }

    /**
     * Mark message as seen.
     */
    public function markSeen($message_id)
    {
        $message = Message::findOrFail($message_id);

        if ($message->receiver_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->update(['seen_status' => true]);

        return response()->json(['success' => true]);
    }
}

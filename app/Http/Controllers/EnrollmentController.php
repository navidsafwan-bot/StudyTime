<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;

class EnrollmentController extends Controller
{
    public function index($course_id)
    {
        $course = Course::with('students')->findOrFail($course_id);
        $user = Auth::user();

        // Check if user has access to this course
        if ($user->role === 'teacher' && $course->teacher_id !== $user->id) {
            abort(403);
        } elseif ($user->role === 'student' && !$course->students->contains($user->id)) {
            abort(403);
        }

        return view('enrollments.index', compact('course'));
    }

    public function store(Request $request, $course_id)
    {
        $course = Course::findOrFail($course_id);
        
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $student = User::where('email', $request->email)->where('role', 'student')->first();

        if (!$student) {
            return back()->with('error', 'Student not found with that email, or the user is not a student.');
        }

        if ($course->students->contains($student->id)) {
            return back()->with('info', 'Student is already enrolled in this course.');
        }

        $course->students()->attach($student->id);

        return back()->with('success', 'Student successfully enrolled.');
    }

    public function destroy($course_id, $student_id)
    {
        $course = Course::findOrFail($course_id);
        
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $course->students()->detach($student_id);

        return back()->with('success', 'Student successfully removed from the course.');
    }
}

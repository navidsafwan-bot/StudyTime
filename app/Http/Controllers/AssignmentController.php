<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Assignment;
use App\Models\Course;

class AssignmentController extends Controller
{
    public function index($course_id)
    {
        $course = Course::with('assignments')->findOrFail($course_id);
        $user = Auth::user();

        // Check if user has access to this course
        if ($user->role === 'teacher' && $course->teacher_id !== $user->id) {
            abort(403);
        } elseif ($user->role === 'student' && !$course->students->contains($user->id)) {
            abort(403);
        }

        return view('assignments.index', compact('course'));
    }

    public function store(Request $request, $course_id)
    {
        $course = Course::findOrFail($course_id);
        
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB limit
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        Assignment::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('courses.show', $course->id)->with('success', 'Assignment created successfully.');
    }

    public function show($id)
    {
        $assignment = Assignment::with(['course.teacher', 'submissions.student'])->findOrFail($id);
        $user = Auth::user();
        
        $course = $assignment->course;

        // Check if user has access to this course
        if ($user->role === 'teacher' && $course->teacher_id !== $user->id) {
            abort(403);
        } elseif ($user->role === 'student' && !$course->students->contains($user->id)) {
            abort(403);
        }

        // Student's own previous submission if any
        $mySubmission = null;
        if ($user->role === 'student') {
            $mySubmission = $assignment->submissions()->where('student_id', $user->id)->first();
        }

        return view('assignments.show', compact('assignment', 'course', 'mySubmission'));
    }

    public function download($id)
    {
        $assignment = Assignment::findOrFail($id);
        
        // Authorization logic can also be placed here if needed.
        if (!$assignment->file_path || !Storage::disk('public')->exists($assignment->file_path)) {
            return back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download($assignment->file_path);
    }
}

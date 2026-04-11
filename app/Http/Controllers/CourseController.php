<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'teacher') {
            $courses = $user->taughtCourses;
        } else {
            $courses = $user->enrolledCourses;
        }
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'teacher_id' => Auth::id(),
        ]);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::with('posts', 'quizzes')->findOrFail($id);
        $user = Auth::user();

        // Check if user has access to this course
        if ($user->role === 'teacher' && $course->teacher_id !== $user->id) {
            abort(403);
        } elseif ($user->role === 'student' && !$course->students->contains($user->id)) {
            abort(403);
        }

        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->update($request->only(['title', 'description']));

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    /**
     * Join a course by title
     */
    public function join(Request $request)
    {
        $request->validate([
            'course_title' => 'required|string|max:255',
        ]);

        $course = Course::where('title', $request->course_title)->first();

        if (!$course) {
            return back()->withErrors(['course_title' => 'Course not found. Please check the course title.']);
        }

        // Check if student is already enrolled
        $user = User::findOrFail(Auth::id());
        if ($user->enrolledCourses->contains($course->id)) {
            return back()->with('info', 'You are already enrolled in this course.');
        }

        // Enroll the student in the course
        $user->enrolledCourses()->attach($course->id);

        return redirect()->route('courses.index')->with('success', 'Successfully joined the course!');
    }
}

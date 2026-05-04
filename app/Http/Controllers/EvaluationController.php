<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index($course_id)
    {
        $course = \App\Models\Course::findOrFail($course_id);
        $user = auth()->user();

        if ($user->role === 'teacher') {
            if ($course->teacher_id !== $user->id) {
                abort(403);
            }
            $evaluations = $course->evaluations()->with('student')->latest()->get();
            return view('evaluations.index', compact('course', 'evaluations'));
        } else {
            if (!$course->students()->where('student_id', $user->id)->exists()) {
                abort(403);
            }
            $existingEvaluation = $course->evaluations()->where('student_id', $user->id)->first();
            return view('evaluations.index', compact('course', 'existingEvaluation'));
        }
    }

    public function store(\Illuminate\Http\Request $request, $course_id)
    {
        $course = \App\Models\Course::findOrFail($course_id);
        $user = auth()->user();

        if ($user->role !== 'student' || !$course->students()->where('student_id', $user->id)->exists()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback_text' => 'nullable|string|max:1000',
        ]);

        $exists = $course->evaluations()->where('student_id', $user->id)->exists();
        if ($exists) {
            return back()->withErrors(['evaluation' => 'You have already evaluated this course.']);
        }

        $course->evaluations()->create([
            'student_id' => $user->id,
            'rating' => $request->rating,
            'feedback_text' => $request->feedback_text,
        ]);

        return redirect()->route('evaluations.index', $course->id)->with('success', 'Thank you for your feedback!');
    }
}

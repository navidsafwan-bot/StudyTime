<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizSubmission;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $courseId = $request->query('course_id');
        if ($courseId) {
            $quizzes = Quiz::where('course_id', $courseId)->with('questions')->get();
        } else {
            $quizzes = Quiz::with('questions')->get();
        }
        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'available_until' => 'nullable|date',
            'course_id' => 'required|exists:courses,id',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.options' => 'required|string',
            'questions.*.correct_answer' => 'required|string',
        ]);

        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'available_until' => $request->available_until,
            'course_id' => $request->course_id,
        ]);

        foreach ($request->questions as $q) {
            $options = array_map('trim', explode(',', $q['options']));
            Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $q['question_text'],
                'options' => $options,
                'correct_answer' => $q['correct_answer'],
            ]);
        }

        return redirect()->route('courses.show', $request->course_id)->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);

        if (Auth::user()->role === 'teacher') {
            $submissions = QuizSubmission::where('quiz_id', $id)->with('user')->get();
            return view('quizzes.show_teacher', compact('quiz', 'submissions'));
        } else {
            // Check if already submitted
            $submission = QuizSubmission::where('quiz_id', $id)->where('user_id', Auth::id())->first();
            if ($submission) {
                return view('quizzes.result', compact('quiz', 'submission'));
            }
            return view('quizzes.take', compact('quiz'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }
        return view('quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $quiz = Quiz::findOrFail($id);
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'available_until' => 'nullable|date',
        ]);

        $quiz->update($request->only(['title', 'description', 'available_until']));

        return redirect()->route('courses.show', $quiz->course_id)->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }
        $quiz->delete();

        return redirect()->route('courses.show', $quiz->course_id)->with('success', 'Quiz deleted successfully.');
    }

    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $answers = $request->answers;
        $score = 0;

        foreach ($quiz->questions as $question) {
            if (isset($answers[$question->id]) && $answers[$question->id] === $question->correct_answer) {
                $score++;
            }
        }

        QuizSubmission::create([
            'quiz_id' => $id,
            'user_id' => Auth::id(),
            'answers' => $answers,
            'score' => $score,
        ]);

        return redirect()->route('courses.show', $quiz->course_id)->with('success', 'Quiz submitted successfully.');
    }
}

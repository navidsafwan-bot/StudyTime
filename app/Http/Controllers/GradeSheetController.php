<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\QuizSubmission;
use App\Models\Submission;

class GradeSheetController extends Controller
{
    public function index($course_id)
    {
        $course = Course::with('quizzes.questions', 'assignments')->findOrFail($course_id);
        $user = auth()->user();

        $total_quizzes = $course->quizzes->count();
        $total_assignments = $course->assignments->count();

        if ($user->role === 'teacher') {
            if ($course->teacher_id !== $user->id) {
                abort(403);
            }

            $studentsStats = [];
            foreach ($course->students as $student) {
                $stats = $this->calculateStudentStats($student->id, $course);
                $stats['student'] = $student;
                $studentsStats[] = $stats;
            }

            return view('grades.teacher_index', compact('course', 'studentsStats', 'total_quizzes', 'total_assignments'));
        } else {
            if (!$course->students()->where('student_id', $user->id)->exists()) {
                abort(403);
            }

            $stats = $this->calculateStudentStats($user->id, $course);
            return view('grades.student_index', compact('course', 'stats', 'total_quizzes', 'total_assignments'));
        }
    }

    private function calculateStudentStats($studentId, $course)
    {
        $total_quizzes = $course->quizzes->count();
        $total_assignments = $course->assignments->count();

        $quizSubmissions = QuizSubmission::where('user_id', $studentId)
            ->whereIn('quiz_id', $course->quizzes->pluck('id'))
            ->with('quiz.questions')
            ->get();

        $attended_quizzes = $quizSubmissions->count();
        $missed_quizzes = $total_quizzes - $attended_quizzes;
        $marks_obtained = $quizSubmissions->sum('score');

        $total_possible_marks = 0;
        foreach ($quizSubmissions as $submission) {
            $total_possible_marks += $submission->quiz->questions->count();
        }

        $submitted_assignments = Submission::where('student_id', $studentId)
            ->whereIn('assignment_id', $course->assignments->pluck('id'))
            ->count();
        $missed_assignments = $total_assignments - $submitted_assignments;

        return [
            'attended_quizzes' => $attended_quizzes,
            'missed_quizzes' => $missed_quizzes,
            'marks_obtained' => $marks_obtained,
            'total_possible_marks' => $total_possible_marks,
            'submitted_assignments' => $submitted_assignments,
            'missed_assignments' => $missed_assignments,
        ];
    }
}

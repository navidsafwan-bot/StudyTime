<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuizController;

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\EnrollmentController;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('courses', CourseController::class);
    Route::post('courses/join', [CourseController::class, 'join'])->name('courses.join');
    Route::resource('posts', PostController::class);
    Route::resource('quizzes', QuizController::class);
    Route::post('quizzes/{id}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');

    // Enrollment routes
    Route::get('courses/{course_id}/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::post('courses/{course_id}/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');
    Route::delete('courses/{course_id}/enrollments/{student_id}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');
    
    // Assignment routes
    Route::get('courses/{course_id}/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::post('courses/{course_id}/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('assignments/{id}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('assignments/download/{id}', [AssignmentController::class, 'download'])->name('assignments.download');
    
    // Submission routes
    Route::post('assignments/{assignment_id}/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('submissions/download/{id}', [SubmissionController::class, 'download'])->name('submissions.download');
}); 
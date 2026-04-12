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
    // Material routes
    Route::get('courses/{course_id}/materials', [\App\Http\Controllers\MaterialController::class, 'index'])->name('materials.index');
    Route::get('courses/{course_id}/materials/create', [\App\Http\Controllers\MaterialController::class, 'create'])->name('materials.create');
    Route::post('courses/{course_id}/materials', [\App\Http\Controllers\MaterialController::class, 'store'])->name('materials.store');
    Route::get('materials/{id}/download', [\App\Http\Controllers\MaterialController::class, 'download'])->name('materials.download');
    Route::delete('materials/{id}', [\App\Http\Controllers\MaterialController::class, 'destroy'])->name('materials.destroy');

    // Schedule routes
    Route::get('courses/{course_id}/schedules', [\App\Http\Controllers\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('courses/{course_id}/schedules/create', [\App\Http\Controllers\ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('courses/{course_id}/schedules', [\App\Http\Controllers\ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('schedules/{id}/edit', [\App\Http\Controllers\ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('schedules/{id}', [\App\Http\Controllers\ScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('schedules/{id}', [\App\Http\Controllers\ScheduleController::class, 'destroy'])->name('schedules.destroy');
}); 
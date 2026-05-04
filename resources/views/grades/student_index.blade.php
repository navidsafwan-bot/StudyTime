@extends('layouts.app')

@section('title', 'Grade Sheet - ' . $course->title)

@section('content')
<div class="container">
    <h2>Grade Sheet: {{ $course->title }}</h2>
    <p class="text-muted">Student: {{ auth()->user()->name }}</p>

    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📊 Quiz Summary</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush text-center fs-5">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Quizzes
                            <span class="badge bg-secondary rounded-pill">{{ $total_quizzes }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Quizzes Attended
                            <span class="badge bg-success rounded-pill">{{ $stats['attended_quizzes'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Quizzes Missed
                            <span class="badge bg-danger rounded-pill">{{ $stats['missed_quizzes'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center mt-3 border-top pt-3">
                            <strong>Marks Obtained (Attended)</strong>
                            <strong class="text-primary">{{ $stats['marks_obtained'] }} / {{ $stats['total_possible_marks'] }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">📝 Assignment Summary</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush text-center fs-5">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Assignments
                            <span class="badge bg-secondary rounded-pill">{{ $total_assignments }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Assignments Submitted
                            <span class="badge bg-success rounded-pill">{{ $stats['submitted_assignments'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Assignments Missed
                            <span class="badge bg-danger rounded-pill">{{ $stats['missed_assignments'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary mt-3">Back to Course</a>
</div>
@endsection

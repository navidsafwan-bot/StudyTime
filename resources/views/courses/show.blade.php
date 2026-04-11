@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $course->title }}</h2>
    <p>{{ $course->description }}</p>
    <p class="text-muted">Teacher: {{ $course->teacher->name }}</p>

    <h3>Course Features</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Posts</h5>
                    <p class="card-text">View announcements and posts.</p>
                    <a href="{{ route('posts.index', ['course_id' => $course->id]) }}" class="btn btn-primary">View Posts</a>
                    @if(auth()->user()->role === 'teacher')
                        <a href="{{ route('posts.create', ['course_id' => $course->id]) }}" class="btn btn-secondary">Create Post</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Quizzes</h5>
                    <p class="card-text">Take quizzes or manage them.</p>
                    <a href="{{ route('quizzes.index', ['course_id' => $course->id]) }}" class="btn btn-primary">View Quizzes</a>
                    @if(auth()->user()->role === 'teacher')
                        <a href="{{ route('quizzes.create', ['course_id' => $course->id]) }}" class="btn btn-secondary">Create Quiz</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Study Materials</h5>
                    <p class="card-text">Access course materials.</p>
                    <a href="#" class="btn btn-primary">View Materials</a>
                    @if(auth()->user()->role === 'teacher')
                        <a href="#" class="btn btn-secondary">Upload Material</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Schedule</h5>
                    <p class="card-text">View tutoring sessions.</p>
                    <a href="#" class="btn btn-primary">View Schedule</a>
                    @if(auth()->user()->role === 'teacher')
                        <a href="#" class="btn btn-secondary">Schedule Session</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Enrollments</h5>
                    <p class="card-text">Manage course enrollments.</p>
                    @if(auth()->user()->role === 'teacher')
                        <a href="#" class="btn btn-primary">View Enrollments</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Assignments</h5>
                    <p class="card-text">Submit or manage assignments.</p>
                    <a href="#" class="btn btn-primary">View Assignments</a>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back to Courses</a>
</div>
@endsection
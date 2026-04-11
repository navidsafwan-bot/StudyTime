@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Courses</h2>
    @if(auth()->user()->role === 'teacher')
        <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Create New Course</a>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if($courses->count() > 0)
        @foreach($courses as $course)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $course->title }}</h5>
                    <p class="card-text">{{ $course->description }}</p>
                    <p class="text-muted">Teacher: {{ $course->teacher->name }}</p>
                    <a href="{{ route('courses.show', $course) }}" class="btn btn-info">Enter Course</a>
                    @if(auth()->user()->role === 'teacher' && $course->teacher_id === auth()->id())
                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning">Edit</a>
                        <form method="POST" action="{{ route('courses.destroy', $course) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        @if(auth()->user()->role === 'teacher')
            <p>You have no courses yet.</p>
            <p><a href="{{ route('courses.create') }}">Create your first course</a></p>
        @else
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Join a Course</h5>
                    <p class="card-text">Enter the exact course title to join a course.</p>
                    <form method="POST" action="{{ route('courses.join') }}">
                        @csrf
                        <div class="form-group">
                            <label for="course_title">Course Title</label>
                            <input type="text" name="course_title" id="course_title" class="form-control" placeholder="Enter course title" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Join Course</button>
                    </form>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
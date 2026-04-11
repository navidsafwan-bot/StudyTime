@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Quizzes</h2>
    @if(request('course_id'))
        @if(auth()->user()->role === 'teacher')
            <a href="{{ route('quizzes.create', ['course_id' => request('course_id')]) }}" class="btn btn-primary mb-3">Create New Quiz</a>
        @endif
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @foreach($quizzes as $quiz)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $quiz->title }}</h5>
                <p class="card-text">{{ $quiz->description }}</p>
                <p class="text-muted">Questions: {{ $quiz->questions->count() }}</p>
                @if($quiz->available_until)
                    <p class="text-muted">Available until: {{ $quiz->available_until->format('M d, Y H:i') }}</p>
                @endif
                <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-info">View</a>
                @if(auth()->user()->role === 'teacher' && $quiz->user_id === auth()->id())
                    <a href="{{ route('quizzes.edit', $quiz) }}" class="btn btn-warning">Edit</a>
                    <form method="POST" action="{{ route('quizzes.destroy', $quiz) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
    @if(request('course_id'))
        <a href="{{ route('courses.show', request('course_id')) }}" class="btn btn-secondary">Back to Course</a>
    @endif
</div>
@endsection
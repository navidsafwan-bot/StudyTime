@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $quiz->title }} - Result</h2>
    <p>Your Score: {{ $submission->score }} / {{ $quiz->questions->count() }}</p>
    <a href="{{ route('quizzes.index', ['course_id' => $quiz->course_id]) }}" class="btn btn-secondary">Back to Quizzes</a>
    <a href="{{ route('courses.show', $quiz->course_id) }}" class="btn btn-secondary">Back to Course</a>
</div>
@endsection
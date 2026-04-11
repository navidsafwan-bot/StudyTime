@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $quiz->title }}</h2>
    <p>{{ $quiz->description }}</p>
    <h4>Questions</h4>
    @foreach($quiz->questions as $index => $question)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $index + 1 }}. {{ $question->question_text }}</h5>
                <ul>
                    @foreach($question->options as $option)
                        <li @if($option === $question->correct_answer) style="font-weight: bold; color: green;" @endif>{{ $option }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
    <h4>Submissions</h4>
    @foreach($submissions as $submission)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $submission->user->name }}</h5>
                <p>Score: {{ $submission->score }} / {{ $quiz->questions->count() }}</p>
            </div>
        </div>
    @endforeach
    <a href="{{ route('quizzes.index', ['course_id' => $quiz->course_id]) }}" class="btn btn-secondary">Back to Quizzes</a>
    <a href="{{ route('courses.show', $quiz->course_id) }}" class="btn btn-secondary">Back to Course</a>
</div>
@endsection
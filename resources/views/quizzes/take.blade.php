@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $quiz->title }}</h2>
    <p>{{ $quiz->description }}</p>
    <form method="POST" action="{{ route('quizzes.submit', $quiz) }}">
        @csrf
        @foreach($quiz->questions as $index => $question)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $index + 1 }}. {{ $question->question_text }}</h5>
                    @foreach($question->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" id="q{{ $question->id }}{{ $option }}">
                            <label class="form-check-label" for="q{{ $question->id }}{{ $option }}">
                                {{ $option }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit Quiz</button>
        <a href="{{ route('courses.show', $quiz->course_id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
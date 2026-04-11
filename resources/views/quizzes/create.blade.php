@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Quiz</h2>
    <form method="POST" action="{{ route('quizzes.store') }}">
        @csrf
        <input type="hidden" name="course_id" value="{{ request('course_id') }}">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="available_until">Available Until (optional)</label>
            <input type="datetime-local" name="available_until" id="available_until" class="form-control">
        </div>
        <h4>Questions</h4>
        <div id="questions">
            <div class="question mb-3">
                <div class="form-group">
                    <label>Question Text</label>
                    <input type="text" name="questions[0][question_text]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Options (comma separated)</label>
                    <input type="text" name="questions[0][options]" class="form-control" placeholder="Option A, Option B, Option C" required>
                </div>
                <div class="form-group">
                    <label>Correct Answer</label>
                    <input type="text" name="questions[0][correct_answer]" class="form-control" required>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" onclick="addQuestion()">Add Question</button>
        <button type="submit" class="btn btn-primary">Create Quiz</button>
        <a href="{{ route('courses.show', request('course_id')) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
let questionCount = 1;
function addQuestion() {
    const questionsDiv = document.getElementById('questions');
    const questionDiv = document.createElement('div');
    questionDiv.className = 'question mb-3';
    questionDiv.innerHTML = `
        <div class="form-group">
            <label>Question Text</label>
            <input type="text" name="questions[${questionCount}][question_text]" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Options (comma separated)</label>
            <input type="text" name="questions[${questionCount}][options]" class="form-control" placeholder="Option A, Option B, Option C" required>
        </div>
        <div class="form-group">
            <label>Correct Answer</label>
            <input type="text" name="questions[${questionCount}][correct_answer]" class="form-control" required>
        </div>
    `;
    questionsDiv.appendChild(questionDiv);
    questionCount++;
}
</script>
@endsection
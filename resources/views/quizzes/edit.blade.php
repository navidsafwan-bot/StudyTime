@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Quiz</h2>
    <form method="POST" action="{{ route('quizzes.update', $quiz) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $quiz->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ $quiz->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="available_until">Available Until (optional)</label>
            <input type="datetime-local" name="available_until" id="available_until" class="form-control" value="{{ $quiz->available_until ? $quiz->available_until->format('Y-m-d\TH:i') : '' }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Quiz</button>
    </form>
</div>
@endsection
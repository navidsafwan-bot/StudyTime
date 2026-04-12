@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Schedule Session for {{ $course->title }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('schedules.store', $course->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="session_date" class="form-label">Date & Time</label>
            <input type="datetime-local" class="form-control" id="session_date" name="session_date" required>
        </div>
        <div class="mb-3">
            <label for="topic" class="form-label">Topic</label>
            <input type="text" class="form-control" id="topic" name="topic" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-control" id="type" name="type" required>
                <option value="class">Class</option>
                <option value="exam">Exam</option>
                <option value="assignment">Assignment</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('schedules.index', $course->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

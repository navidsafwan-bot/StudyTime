@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Assignments for {{ $course->title }}</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(auth()->user()->role === 'teacher')
    <div class="card mb-4 mt-4">
        <div class="card-header">Create New Assignment</div>
        <div class="card-body">
            <form action="{{ route('assignments.store', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Instructions File (PDF/DOC/DOCX)</label>
                    <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx">
                </div>
                <div class="mb-3">
                    <label>Deadline</label>
                    <input type="datetime-local" name="deadline" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Create Assignment</button>
            </form>
        </div>
    </div>
    @else
    <div class="mt-4"></div>
    @endif

    @if($course->assignments && $course->assignments->count() > 0)
        <div class="list-group">
            @foreach($course->assignments as $assignment)
                <a href="{{ route('assignments.show', $assignment->id) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $assignment->title }}</h5>
                        <small>Due: {{ $assignment->deadline->format('M d, Y H:i') }}</small>
                    </div>
                    <p class="mb-1">{{ Str::limit($assignment->description, 100) }}</p>
                </a>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">No assignments created yet.</div>
    @endif

    <div class="mt-4">
        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary">Back to Course</a>
    </div>
</div>
@endsection

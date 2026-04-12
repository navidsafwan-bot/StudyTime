@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Enrolled Students for {{ $course->title }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if(auth()->user()->role === 'teacher')
    <div class="card mb-4 mt-4">
        <div class="card-body">
            <form action="{{ route('enrollments.store', $course->id) }}" method="POST" class="d-flex">
                @csrf
                <input type="email" name="email" class="form-control me-2" placeholder="Student Email to Enroll" required>
                <button type="submit" class="btn btn-success">Enroll New Student</button>
            </form>
        </div>
    </div>
    @else
    <div class="mt-4"></div>
    @endif

    @if($course->students && $course->students->count() > 0)
        <ul class="list-group">
            @foreach($course->students as $student)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $student->name }} ({{ $student->email }})
                    @if(auth()->user()->role === 'teacher')
                        <form action="{{ route('enrollments.destroy', ['course_id' => $course->id, 'student_id' => $student->id]) }}" method="POST" onsubmit="return confirm('Remove student?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-info">No students enrolled yet.</div>
    @endif

    <div class="mt-4">
        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary">Back to Course</a>
    </div>
</div>
@endsection

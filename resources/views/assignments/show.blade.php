@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="mb-4">
        <h2>{{ $assignment->title }}</h2>
        <p class="text-muted">Course: <a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a> | Due: {{ $assignment->deadline->format('M d, Y H:i') }}</p>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Instructions</h5>
            <p>{{ $assignment->description }}</p>

            @if($assignment->file_path)
                <a href="{{ route('assignments.download', $assignment->id) }}" class="btn btn-outline-primary">Download Attachment</a>
            @endif
        </div>
    </div>

    @if(auth()->user()->role === 'teacher')
        <h3>Submissions</h3>
        @if($assignment->submissions->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Submitted At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignment->submissions as $submission)
                            <tr>
                                <td>{{ $submission->student->name }}</td>
                                <td>{{ $submission->submitted_at->format('M d, Y H:i') }}</td>
                                <td>
                                    @if($submission->submitted_at->greaterThan($assignment->deadline))
                                        <span class="badge bg-danger">Late</span>
                                    @else
                                        <span class="badge bg-success">On Time</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('submissions.download', $submission->id) }}" class="btn btn-sm btn-primary">Download</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No submissions yet.</p>
        @endif
    @else
        <h3>Your Submission</h3>
        @if($mySubmission)
            <div class="alert alert-info">
                You submitted an assignment on {{ $mySubmission->submitted_at->format('M d, Y H:i') }}.
                <br>
                <a href="{{ route('submissions.download', $mySubmission->id) }}" class="btn btn-sm btn-secondary mt-2">Download Your Submission</a>
            </div>
        @else
            <div class="alert alert-warning">You have not submitted anything yet.</div>
        @endif

        @if(now()->lessThanOrEqualTo($assignment->deadline))
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('submissions.store', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload Submission File (Max 10MB)</label>
                            <input class="form-control" type="file" id="file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-success">{{ $mySubmission ? 'Update Submission' : 'Submit Assignment' }}</button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-danger mt-3">
                The deadline for this assignment has passed. Submissions are no longer accepted.
            </div>
        @endif
    @endif
    
    <div class="mt-4">
        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary">Back to Course</a>
    </div>
</div>
@endsection

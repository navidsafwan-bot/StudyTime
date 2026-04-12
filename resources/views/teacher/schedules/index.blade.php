@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Course Schedule: {{ $course->title }}</h2>
        <a href="{{ route('schedules.create', $course->id) }}" class="btn btn-primary">Schedule Session</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Topic</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr class="@if($schedule->type == 'class') table-primary @elseif($schedule->type == 'exam') table-danger @else table-success @endif">
                    <td>{{ $schedule->session_date->format('M d, Y - h:i A') }}</td>
                    <td>{{ $schedule->topic }}</td>
                    <td>{{ ucfirst($schedule->type) }}</td>
                    <td>
                        <a href="{{ route('schedules.edit', $schedule->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No routine scheduled yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary mt-3">Back to Course Dashboard</a>
</div>
@endsection

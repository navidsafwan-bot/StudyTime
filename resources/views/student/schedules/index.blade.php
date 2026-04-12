@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h2>Course Schedule (Routine): {{ $course->title }}</h2>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Topic</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr class="@if($schedule->type == 'class') table-primary @elseif($schedule->type == 'exam') table-danger @else table-success @endif">
                    <td>{{ $schedule->session_date->format('M d, Y - h:i A') }}</td>
                    <td>{{ $schedule->topic }}</td>
                    <td>{{ ucfirst($schedule->type) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No routine scheduled yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary mt-3">Back to Course Dashboard</a>
</div>
@endsection

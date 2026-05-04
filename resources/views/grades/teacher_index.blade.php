@extends('layouts.app')

@section('title', 'Grade Sheet - ' . $course->title)

@section('content')
<div class="container">
    <h2>Grade Sheet: {{ $course->title }}</h2>
    <p class="text-muted">Total Quizzes: {{ $total_quizzes }} | Total Assignments: {{ $total_assignments }}</p>

    <div class="card mt-4">
        <div class="card-body table-responsive">
            <h5 class="card-title mb-3">Student Performances</h5>
            @if(count($studentsStats) > 0)
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th rowspan="2" class="align-middle text-start">Student Name</th>
                            <th colspan="3">Quiz Stats</th>
                            <th colspan="2">Assignment Stats</th>
                        </tr>
                        <tr>
                            <th>Attended / Total</th>
                            <th>Missed</th>
                            <th>Marks (Obtained / Total)</th>
                            <th>Submitted / Total</th>
                            <th>Missed</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach($studentsStats as $stat)
                            <tr>
                                <td class="text-start fw-bold">{{ $stat['student']->name }}</td>
                                <td>{{ $stat['attended_quizzes'] }} / {{ $total_quizzes }}</td>
                                <td>
                                    <span class="badge {{ $stat['missed_quizzes'] > 0 ? 'bg-danger' : 'bg-success' }}">
                                        {{ $stat['missed_quizzes'] }}
                                    </span>
                                </td>
                                <td>{{ $stat['marks_obtained'] }} / {{ $stat['total_possible_marks'] }}</td>
                                <td>{{ $stat['submitted_assignments'] }} / {{ $total_assignments }}</td>
                                <td>
                                    <span class="badge {{ $stat['missed_assignments'] > 0 ? 'bg-danger' : 'bg-success' }}">
                                        {{ $stat['missed_assignments'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No students are currently enrolled in this course.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary mt-3">Back to Course</a>
</div>
@endsection

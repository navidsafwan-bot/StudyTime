@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h2>Study Materials for {{ $course->title }}</h2>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Upload Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($materials as $material)
                <tr>
                    <td>{{ $material->title }}</td>
                    <td>{{ $material->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('materials.download', $material->id) }}" class="btn btn-success btn-sm">Download</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No materials available yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary mt-3">Back to Course Dashboard</a>
</div>
@endsection

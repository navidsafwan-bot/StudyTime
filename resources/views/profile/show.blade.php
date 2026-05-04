@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>User Profile</span>
                    <a href="javascript:history.back()" class="btn btn-sm btn-secondary">Go Back</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            @if($targetUser->profile_image)
                                <img src="{{ asset('storage/' . $targetUser->profile_image) }}" alt="Profile Picture" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto text-white" style="width: 150px; height: 150px; font-size: 3rem;">
                                    {{ strtoupper(substr($targetUser->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3 class="mb-1">{{ $targetUser->name }}</h3>
                            <span class="badge bg-primary text-capitalize mb-3">{{ $targetUser->role }}</span>
                            
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="width: 150px;">Education:</th>
                                        <td>{{ $targetUser->education ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Age:</th>
                                        <td>{{ $targetUser->age ?? 'N/A' }}</td>
                                    </tr>
                                    @if($targetUser->role === 'teacher')
                                        <tr>
                                            <th>Expertise:</th>
                                            <td>{{ $targetUser->expertise ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Experience:</th>
                                            <td>{{ $targetUser->teaching_experience ?? 'N/A' }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="border-bottom pb-2">Course Information</h5>
                        @if($targetUser->role === 'teacher')
                            <h6>Courses Taught:</h6>
                            <ul class="list-group">
                                @forelse($targetUser->taughtCourses as $course)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $course->title }}
                                        <span class="badge bg-secondary rounded-pill">{{ $course->students()->count() ?? 0 }} Students</span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">No courses taught.</li>
                                @endforelse
                            </ul>
                        @else
                            <h6>Enrolled Courses:</h6>
                            <ul class="list-group">
                                @forelse($targetUser->enrolledCourses as $course)
                                    <li class="list-group-item">
                                        {{ $course->title }} <small class="text-muted">(Instructor: {{ $course->teacher->name ?? 'N/A' }})</small>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">No enrolled courses.</li>
                                @endforelse
                            </ul>
                            @if($targetUser->academic_info)
                                <div class="mt-3">
                                    <h6>Academic Info:</h6>
                                    <p class="text-muted">{{ $targetUser->academic_info }}</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

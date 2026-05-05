@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>My Profile</span>
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">Back to Dashboard</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        @if($user->profile_image)
                            <img src="{{ Storage::url($user->profile_image) }}" alt="Profile Picture" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto text-white" style="width: 150px; height: 150px; font-size: 3rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <h4 class="mt-2">{{ $user->name }}</h4>
                        <span class="badge bg-primary text-capitalize">{{ $user->role }}</span>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age" value="{{ old('age', $user->age) }}" min="1">
                                @error('age') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="education" class="form-label">Educational Qualification</label>
                                <input type="text" class="form-control @error('education') is-invalid @enderror" id="education" name="education" value="{{ old('education', $user->education) }}">
                                @error('education') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Picture (JPG, PNG)</label>
                            <input class="form-control @error('profile_image') is-invalid @enderror" type="file" id="profile_image" name="profile_image" accept=".jpg,.jpeg,.png">
                            @error('profile_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        @if($user->role === 'teacher')
                            <h5 class="mt-4 border-bottom pb-2">Teacher Information</h5>
                            <div class="mb-3">
                                <label for="expertise" class="form-label">Expertise / Subjects</label>
                                <input type="text" class="form-control @error('expertise') is-invalid @enderror" id="expertise" name="expertise" value="{{ old('expertise', $user->expertise) }}" placeholder="e.g., Mathematics, Computer Science">
                                @error('expertise') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="teaching_experience" class="form-label">Teaching Experience</label>
                                <textarea class="form-control @error('teaching_experience') is-invalid @enderror" id="teaching_experience" name="teaching_experience" rows="3">{{ old('teaching_experience', $user->teaching_experience) }}</textarea>
                                @error('teaching_experience') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        @endif

                        @if($user->role === 'student')
                            <h5 class="mt-4 border-bottom pb-2">Student Information</h5>
                            <div class="mb-3">
                                <label for="academic_info" class="form-label">Academic Info (Bio)</label>
                                <textarea class="form-control @error('academic_info') is-invalid @enderror" id="academic_info" name="academic_info" rows="3">{{ old('academic_info', $user->academic_info) }}</textarea>
                                @error('academic_info') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100">Save/Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Course Evaluations - ' . $course->title)

@section('content')
<div class="container">
    <h2>Course Evaluations: {{ $course->title }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(auth()->user()->role === 'teacher')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Student Feedback</h5>
                @if($evaluations->count() > 0)
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Rating</th>
                                <th>Feedback</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evaluations as $evaluation)
                                <tr>
                                    <td>{{ $evaluation->student->name }}</td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $evaluation->rating)
                                                <span class="text-warning">★</span>
                                            @else
                                                <span class="text-secondary">☆</span>
                                            @endif
                                        @endfor
                                    </td>
                                    <td>{{ $evaluation->feedback_text ?: 'No additional feedback' }}</td>
                                    <td>{{ $evaluation->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted mt-3">No evaluations submitted yet.</p>
                @endif
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                @if($existingEvaluation)
                    <h5 class="card-title text-success">You have already evaluated this course.</h5>
                    <p class="mt-3">Your rating:</p>
                    <div class="fs-4">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $existingEvaluation->rating)
                                <span class="text-warning">★</span>
                            @else
                                <span class="text-secondary">☆</span>
                            @endif
                        @endfor
                    </div>
                    <p class="mt-3">Your feedback:</p>
                    <p class="text-muted">{{ $existingEvaluation->feedback_text ?: 'None' }}</p>
                @else
                    <h5 class="card-title">Submit an Evaluation</h5>
                    <form method="POST" action="{{ route('evaluations.store', $course->id) }}" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="rating-input fs-3" style="cursor: pointer;">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star" data-value="{{ $i }}">☆</span>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" required>
                        </div>
                        <div class="mb-3">
                            <label for="feedback_text" class="form-label">Personal Feedback (Optional)</label>
                            <textarea name="feedback_text" id="feedback_text" rows="4" class="form-control" placeholder="Share your thoughts about this course..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Evaluation</button>
                    </form>
                @endif
            </div>
        </div>
    @endif
    
    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary mt-3">Back to Course</a>
</div>

@if(auth()->user()->role === 'student' && (!isset($existingEvaluation) || !$existingEvaluation))
@push('styles')
<style>
    .rating-input .star {
        color: #ccc;
    }
    .rating-input .star.active, .rating-input .star.hover {
        color: #ffc107;
    }
</style>
@endpush
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-input .star');
    const ratingInput = document.getElementById('rating-input');

    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            const val = this.getAttribute('data-value');
            stars.forEach(s => {
                if(s.getAttribute('data-value') <= val) {
                    s.classList.add('hover');
                    s.innerHTML = '★';
                } else {
                    s.classList.remove('hover');
                    s.innerHTML = '☆';
                }
            });
        });

        star.addEventListener('mouseout', function() {
            const currentVal = ratingInput.value;
            stars.forEach(s => {
                s.classList.remove('hover');
                if(s.getAttribute('data-value') <= currentVal) {
                    s.classList.add('active');
                    s.innerHTML = '★';
                } else {
                    s.classList.remove('active');
                    s.innerHTML = '☆';
                }
            });
        });

        star.addEventListener('click', function() {
            const val = this.getAttribute('data-value');
            ratingInput.value = val;
            stars.forEach(s => {
                if(s.getAttribute('data-value') <= val) {
                    s.classList.add('active');
                    s.innerHTML = '★';
                } else {
                    s.classList.remove('active');
                    s.innerHTML = '☆';
                }
            });
        });
    });
});
</script>
@endif
@endsection

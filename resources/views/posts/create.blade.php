@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Post</h2>
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf
        <input type="hidden" name="course_id" value="{{ request('course_id') }}">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" rows="10" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Post</button>
        <a href="{{ route('courses.show', request('course_id')) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
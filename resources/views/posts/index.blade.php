@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Posts</h2>
    @if(request('course_id'))
        @if(auth()->user()->role === 'teacher')
            <a href="{{ route('posts.create', ['course_id' => request('course_id')]) }}" class="btn btn-primary mb-3">Create New Post</a>
        @endif
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @foreach($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                <p class="text-muted">By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</p>
                <a href="{{ route('posts.show', $post) }}" class="btn btn-info">Read More</a>
                @if(auth()->user()->role === 'teacher' && $post->user_id === auth()->id())
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Edit</a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
    @if(request('course_id'))
        <a href="{{ route('courses.show', request('course_id')) }}" class="btn btn-secondary">Back to Course</a>
    @endif
</div>
@endsection
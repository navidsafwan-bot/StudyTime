@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $post->title }}</h2>
    <p class="text-muted">By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</p>
    <p>{{ $post->content }}</p>
    <a href="{{ route('posts.index', ['course_id' => $post->course_id]) }}" class="btn btn-secondary">Back to Posts</a>
    <a href="{{ route('courses.show', $post->course_id) }}" class="btn btn-secondary">Back to Course</a>
</div>
@endsection
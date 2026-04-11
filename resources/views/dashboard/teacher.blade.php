@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Teacher Dashboard</h2>
    <p>Welcome, {{ auth()->user()->name }}!</p>
    <h3>Available Features:</h3>
    <ul>
        <li><a href="#">Manage Courses</a></li>
        <li><a href="{{ route('posts.index') }}">Posts (Announcements)</a></li>
        <li><a href="{{ route('quizzes.index') }}">Quizzes</a></li>
        <li><a href="#">Upload Study Materials</a></li>
        <li><a href="#">Schedule Tutoring Sessions</a></li>
        <li><a href="#">Create New Courses</a></li>
        <li><a href="#">Edit Courses</a></li>
        <li><a href="#">Delete Courses</a></li>
        <li><a href="#">View Enrollments</a></li>
    </ul>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
@endsection
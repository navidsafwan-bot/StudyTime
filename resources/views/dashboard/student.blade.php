@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Student Dashboard</h2>
    <p>Welcome, {{ auth()->user()->name }}!</p>
    <h3>Available Features:</h3>
    <ul>
        <li><a href="#">Enrolled Courses</a></li>
        <li><a href="{{ route('posts.index') }}">View Posts</a></li>
        <li><a href="{{ route('quizzes.index') }}">Take Quizzes</a></li>
        <li><a href="#">Access Study Materials</a></li>
        <li><a href="#">View Scheduled Sessions</a></li>
        <li><a href="#">Enroll in Courses</a></li>
        <li><a href="#">View Grades</a></li>
        <li><a href="#">Submit Assignments</a></li>
        <li><a href="#">Discussion Forums</a></li>
    </ul>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
@endsection
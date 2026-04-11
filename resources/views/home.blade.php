@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome to StudyTime</h1>
    <p>The all-in-one platform for teachers to manage schedules and students to track their learning progress.</p>
    @if(!auth()->check())
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('signup') }}" class="btn btn-secondary">Sign Up</a>
    @else
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
    @endif
</div>
@endsection
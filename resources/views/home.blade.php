@extends('layouts.app')

@push('styles')
    @vite(['resources/css/home.css'])
@endpush

@section('content')
<div class="hero-wrapper">
    <div class="glass-blob"></div>
    
    <div class="container">
        <div class="hero-content">
            <span class="badge">Version 2.0 is live</span>
            <h1>Manage your studies <span class="text-gradient">without the stress.</span></h1>
            <p>The all-in-one platform for teachers to manage schedules and students to track their learning progress in real-time.</p>
            
            <div class="cta-group">
                @if(!auth()->check())
                    <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
                    <a href="{{ route('signup') }}" class="btn btn-outline">Create Free Account</a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Enter Dashboard →</a>
                @endif
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>10k+</h3>
                <p>Active Students</p>
            </div>
            <div class="stat-card">
                <h3>500+</h3>
                <p>Expert Teachers</p>
            </div>
            <div class="stat-card">
                <h3>24/7</h3>
                <p>Live Support</p>
            </div>
        </div>
    </div>
</div>
@endsection
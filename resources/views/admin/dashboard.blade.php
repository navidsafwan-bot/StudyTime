@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Card 1 -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-b-4 border-indigo-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                <i class="fas fa-users fa-2x"></i>
            </div>
            <div class="ml-4">
                <p class="mb-2 text-sm font-medium text-gray-600">Total Users</p>
                <p class="text-3xl font-semibold text-gray-800">{{ $stats['total_users'] }}</p>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-b-4 border-green-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fas fa-book fa-2x"></i>
            </div>
            <div class="ml-4">
                <p class="mb-2 text-sm font-medium text-gray-600">Total Courses</p>
                <p class="text-3xl font-semibold text-gray-800">{{ $stats['total_courses'] }}</p>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-b-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-user-check fa-2x"></i>
            </div>
            <div class="ml-4">
                <p class="mb-2 text-sm font-medium text-gray-600">Active Users</p>
                <p class="text-3xl font-semibold text-gray-800">{{ $stats['active_users'] }}</p>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-b-4 border-yellow-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <i class="fas fa-star fa-2x"></i>
            </div>
            <div class="ml-4">
                <p class="mb-2 text-sm font-medium text-gray-600">Avg Course Rating</p>
                <p class="text-3xl font-semibold text-gray-800">{{ number_format($stats['avg_rating'], 1) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Welcome to StudyTime Admin Panel</h2>
    <p class="text-gray-600">Use the sidebar to navigate through users, courses, and evaluations. You have full control to manage the system and monitor its performance.</p>
</div>
@endsection

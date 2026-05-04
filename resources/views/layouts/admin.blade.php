<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - StudyTime</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Sidebar -->
    <div class="bg-indigo-900 shadow-xl h-16 fixed bottom-0 md:relative md:h-screen z-10 w-full md:w-64">
        <div class="md:mt-6 md:w-64 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
            <div class="flex items-center justify-center h-14 border-b border-indigo-800 hidden md:flex">
                <span class="text-white text-2xl font-semibold"><i class="fas fa-book-reader mr-2"></i>StudyTime</span>
            </div>
            <ul class="list-reset flex flex-row md:flex-col pt-3 md:py-3 px-1 md:px-2 text-center md:text-left">
                <li class="mr-3 flex-1">
                    <a href="{{ route('admin.dashboard') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-pink-500 text-pink-500' : 'border-gray-800 hover:border-pink-500' }}">
                        <i class="fas fa-tachometer-alt pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Dashboard</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{ route('admin.users.index') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ request()->routeIs('admin.users.*') ? 'border-pink-500 text-pink-500' : 'border-gray-800 hover:border-pink-500' }}">
                        <i class="fas fa-users pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Users</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{ route('admin.courses.index') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ request()->routeIs('admin.courses.*') ? 'border-pink-500 text-pink-500' : 'border-gray-800 hover:border-pink-500' }}">
                        <i class="fas fa-book pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Courses</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{ route('admin.evaluations.index') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ request()->routeIs('admin.evaluations.*') ? 'border-pink-500 text-pink-500' : 'border-gray-800 hover:border-pink-500' }}">
                        <i class="fas fa-star pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Evaluations</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <form method="POST" action="{{ route('logout') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-red-500">
                        @csrf
                        <button type="submit" class="w-full text-left">
                            <i class="fas fa-sign-out-alt pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 pb-24 md:pb-5">
        <!-- Top Nav -->
        <div class="bg-white shadow w-full p-4 flex justify-between items-center z-10">
            <h1 class="text-xl font-semibold">@yield('header')</h1>
            <div class="flex items-center">
                <span class="mr-4 text-gray-600">Admin Panel</span>
                <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                    A
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mt-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <div class="p-6">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>

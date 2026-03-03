<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyTime - Tuition Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-900">
    <!-- Navbar -->
    <nav class="flex items-center justify-between px-10 py-6 bg-white shadow-sm">
        <div class="text-2xl font-bold text-indigo-600">StudyTime</div>
        <div class="space-x-6">
            <a href="#" class="hover:text-indigo-600 transition">About</a>
            <a href="#" class="hover:text-indigo-600 transition">Contact</a>
            <button class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">Login</button>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="text-center py-20 px-4 bg-gradient-to-b from-white to-slate-50">
        <h1 class="text-5xl font-extrabold mb-4">Master Your Tuition Tasks</h1>
        <p class="text-xl text-slate-600 max-w-2xl mx-auto">The all-in-one platform for teachers to manage schedules and students to track their learning progress.</p>
        <div class="mt-8 space-x-4">
            <a href="#" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-full font-semibold shadow-lg hover:shadow-indigo-200 transition">I am a Student</a>
            <a href="#" class="inline-block bg-white border-2 border-indigo-600 text-indigo-600 px-8 py-3 rounded-full font-semibold hover:bg-indigo-50 transition">I am a Teacher</a>
        </div>
    </header>

    <!-- Features -->
    <section class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 py-12 px-6">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <div class="text-3xl mb-4">📅</div>
            <h3 class="font-bold text-xl mb-2">Smart Scheduling</h3>
            <p class="text-slate-500">Easily organize class times and never miss a tuition session again.</p>
        </div>
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <div class="text-3xl mb-4">📝</div>
            <h3 class="font-bold text-xl mb-2">Task Management</h3>
            <p class="text-slate-500">Teachers can assign homework and students can upload completed tasks.</p>
        </div>
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <div class="text-3xl mb-4">📊</div>
            <h3 class="font-bold text-xl mb-2">Progress Tracking</h3>
            <p class="text-slate-500">Detailed reports on performance and attendance for both parties.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-10 text-slate-400 border-t mt-12">
        <p>&copy; {{ date('Y') }} StudyTime. All rights reserved.</p>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyTime - Tuition Management</title>
    @vite(['resources/css/home.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Background animated shapes for the glass effect to stand out -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <div class="container">
        <!-- Navbar -->
        <nav class="navbar glass">
            <div class="logo">StudyTime</div>
            <div class="nav-links">
                <a href="aboutus">About</a>
                <a href="#">Contact</a>
                <button class="btn btn-login">Login</button>
            </div>
        </nav>

        <!-- Hero Section -->
        <header class="hero glass">
            <h1>Master Your Tuition Tasks</h1>
            <p class="subtitle">The all-in-one platform for teachers to manage schedules and students to track their learning progress.</p>
            
            <div class="role-buttons">
                <a href="#" class="btn btn-primary">I am a Student</a>
                <a href="#" class="btn btn-outline">I am a Teacher</a>
            </div>

            <div class="signup-area">
                <p>Did not have an account?</p>
                <a href="{{ route('signuppage') }}" class="btn btn-primary">Signup Now</a>
            </div>
        </header>

        <!-- Features -->
        <section class="features">
            <div class="feature-card glass">
                <div class="icon">📅</div>
                <h3>Smart Scheduling</h3>
                <p>Easily organize class times and never miss a tuition session again.</p>
            </div>
            <div class="feature-card glass">
                <div class="icon">📝</div>
                <h3>Task Management</h3>
                <p>Teachers can assign homework and students can upload completed tasks.</p>
            </div>
            <div class="feature-card glass">
                <div class="icon">📊</div>
                <h3>Progress Tracking</h3>
                <p>Detailed reports on performance and attendance for both parties.</p>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer glass">
            <p>&copy; {{ date('Y') }} StudyTime. All rights reserved.</p>
        </footer>
    </div>

</body>
</html>
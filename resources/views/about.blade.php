<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - StudyTime</title>
    @vite(['resources/css/about.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Background animated shapes for the glass effect -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <div class="container">
        <!-- Navbar -->
        <nav class="navbar glass">
            <a href="/" class="logo">StudyTime</a>
            <div class="nav-links">
                <a href="/">Home</a>
                <a href="/about" class="active">About</a>
                <a href="/contact">Contact</a>
                <button class="btn btn-login">Login</button>
            </div>
        </nav>

        <!-- About Hero Section -->
        <header class="hero glass about-hero">
            <h1>About StudyTime</h1>
            <p class="subtitle">A next-generation platform to digitally manage tutoring activities, ensuring efficient course management and structured academic interaction.</p>
        </header>

        <!-- Project Story & Context -->
        <section class="about-grid">
            <div class="glass info-card">
                <h3>Our Story</h3>
                <p>StudyTime is a redevelopment of a previous Core PHP system. We recognized the need for better scalability, maintainability, and adherence to modern development standards. By completely rebuilding the platform using <strong>Laravel 10</strong> and the <strong>MVC architectural pattern</strong>, we are ensuring a robust experience for both teachers and students.</p>
            </div>
            
            <div class="glass info-card">
                <h3>Academic Context</h3>
                <p>This application is proudly developed as a <strong>Software Engineering Course Project</strong>. It goes beyond just coding—it demonstrates practical implementation of system design concepts, UML modeling, database normalization, and structured sprint-based development methodologies.</p>
            </div>
        </section>

        <!-- Core Modules & Features -->
        <div class="section-header text-center">
            <h2>Core Modules</h2>
            <p>Empowering educators and learners with essential tools.</p>
        </div>

        <section class="features">
            <div class="feature-card glass">
                <div class="icon">📚</div>
                <h3>Course & Enrollment</h3>
                <p>Teachers can easily create and manage courses, while students can browse and enroll in their desired subjects with a seamless relationship mapping.</p>
            </div>
            <div class="feature-card glass">
                <div class="icon">📝</div>
                <h3>Quiz Management</h3>
                <p>Educators can define quiz durations and upload documents. Students can access and submit their responses within strictly specified timeframes.</p>
            </div>
            <div class="feature-card glass">
                <div class="icon">🗓️</div>
                <h3>Session Scheduling</h3>
                <p>Advanced scheduling tools allow teachers to set up tutoring sessions with specific topics and dates, helping students stay organized and on track.</p>
            </div>
        </section>

        <!-- Tech Stack Display -->
        <section class="glass tech-stack-card">
            <h3>Technology Stack</h3>
            <div class="tech-badges">
                <span class="badge">Laravel 10</span>
                <span class="badge">PHP</span>
                <span class="badge">MySQL</span>
                <span class="badge">Blade Engine</span>
                <span class="badge">MVC Architecture</span>
            </div>
        </section>
<!-- Meet the Makers Section -->
        <div class="section-header text-center">
            <h2>Meet the Makers</h2>
            <p>The developers behind the StudyTime platform.</p>
        </div>

        <section class="team-grid">
            <!-- Maker 1 -->
            <div class="team-card feature-card glass">
                <div class="avatar">
                    <!-- Placeholder image, replace src with actual image path -->
                    <img src="https://ui-avatars.com/api/?name=Developer+One&background=4f46e5&color=fff&size=150" alt="Maker 1">
                </div>
                <h3>Developer One</h3>
                <span class="role">Lead Developer</span>
                <p>Specializes in Laravel MVC architecture, database design, and backend logic.</p>
                <a href="{{ route('navidinfo') }}"  class="btn btn-outline portfolio-btn">View Portfolio</a>
            </div>

            <!-- Maker 2 -->
            <div class="team-card feature-card glass">
                <div class="avatar">
                    <img src="https://ui-avatars.com/api/?name=Developer+Two&background=ec4899&color=fff&size=150" alt="Maker 2">
                </div>
                <h3>Developer Two</h3>
                <span class="role">Frontend Developer</span>
                <p>Focuses on Blade templating, Glassmorphism UI/UX design, and responsiveness.</p>
                <a href="{{ route('samsulinfo') }}"  class="btn btn-outline portfolio-btn">View Portfolio</a>
            </div>

            <!-- Maker 3 -->
            <div class="team-card feature-card glass">
                <div class="avatar">
                    <img src="https://ui-avatars.com/api/?name=Developer+Three&background=0ea5e9&color=fff&size=150" alt="Maker 3">
                </div>
                <h3>Developer Three</h3>
                <span class="role">QA & System Analyst</span>
                <p>Ensures software engineering best practices, UML modeling, and system testing.</p>
                <a href="{{ route('bishalinfo') }}"  class="btn btn-outline portfolio-btn">View Portfolio</a>
            </div>
        </section>
        <!-- Footer -->
        <footer class="footer glass">
            <p>&copy; {{ date('Y') }} StudyTime Tutoring Management System. All rights reserved.</p>
        </footer>
    </div>

</body>
</html>
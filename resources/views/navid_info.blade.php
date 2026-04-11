<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Portfolio</title>
    <link rel="stylesheet" href="style.css">
    @vite('resources/css/maker_info/app.css')
    @vite('resources/js/app.js')
</head>
<body>
    <!-- Background animated shapes for the glass effect -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <div class="container">
        <!-- Simple Back Navigation -->
        <nav class="navbar glass" style="margin-bottom: 2rem;">
            <a href="{{ route('aboutus') }}" class="logo" style="font-size: 1.2rem;">⬅ Back to About</a>
        </nav>  

        <!-- Profile Hero Section -->
        <header class="portfolio-hero glass text-center">
            <div class="portfolio-avatar">
                <!-- Replace with your actual photo -->
                <img src="{{ asset('image/navid.jpg') }}" alt="Developer Profile">
            </div>
            <h1>Navid Safwan</h1>
            <p class="role-title">Software Engineering Student & Developer</p>
            <p class="bio">I build scalable web applications and love solving complex problems. Passionate about clean code, MVC architecture, and creating user-friendly interfaces.</p>
            
            <div class="social-links mt-3">
                <a href="https://github.com/yourusername" target="_blank" class="btn btn-primary">GitHub</a>
                <a href="https://linkedin.com/in/yourusername" target="_blank" class="btn btn-outline">LinkedIn</a>
                <a href="mailto:your.email@example.com" class="btn btn-outline">Email Me</a>
            </div>
        </header>

        <!-- Details Grid -->
        <div class="portfolio-grid">
            <!-- About Section -->
            <section class="glass p-card">
                <h2>About Me</h2>
                <p>Hello! I am currently studying Software Engineering and working on the <strong>StudyTime Tutoring Management System</strong>. My core responsibilities include designing the database architecture, implementing backend logic, and ensuring the system adheres to modern web standards.</p>
                <br>
                <p>When I'm not coding, I enjoy learning about new technologies, contributing to open-source projects, and reading about software design patterns.</p>
            </section>
            
            <!-- Skills Section (Reusing the tech badges from the About page) -->
            <section class="glass p-card">
                <h2>My Skills</h2>
                <div class="tech-badges" style="justify-content: flex-start; margin-top: 1.5rem;">
                    <span class="badge">Laravel / PHP</span>
                    <span class="badge">MySQL</span>
                    <span class="badge">JavaScript</span>
                    <span class="badge">HTML & CSS</span>
                    <span class="badge">Git & GitHub</span>
                    <span class="badge">UML Modeling</span>
                </div>
            </section>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
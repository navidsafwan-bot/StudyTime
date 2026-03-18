<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

📚 Tutoring Management System
A Laravel-Based Web Application
Software Engineering Course Project
1. Project Overview

The Tutoring Management System is a web-based academic platform developed using the Laravel framework. This project aims to digitally manage tutoring activities between teachers and students, ensuring efficient course management, structured content delivery, and organized academic interaction.

The system is being developed following standard Software Engineering principles, including modular design, MVC architecture, database normalization, and sprint-based development methodology.

This project is a redevelopment of a previously implemented system (Core PHP version), now reconstructed using Laravel to ensure scalability, maintainability, and adherence to modern development standards.

2. Project Objectives

The primary objectives of this project are:

To implement a structured MVC-based web application using Laravel

To design a relational database with proper entity relationships

To apply software engineering concepts such as system architecture planning and UML modeling

To ensure maintainable and reusable code structure

To follow sprint-based development methodology

3. Development Methodology

The project follows a Sprint-Based Incremental Development Model, structured as follows:

Sprint 1

Framework setup

Environment configuration

Database schema planning

System architecture design

Class diagram preparation

Base template creation

Future sprints will focus on functional module implementation and testing.

4. System Architecture

The system follows the Model-View-Controller (MVC) architectural pattern provided by Laravel.

Model

Handles database interaction using Eloquent ORM

Defines entity relationships

Ensures data integrity

View

Built using Blade templating engine

Provides structured and reusable layouts

Supports dynamic content rendering

Controller

Contains business logic

Manages request handling and response generation

5. Core Functional Modules

The system consists of the following major modules:

5.1 Course Management

Teachers can create, update, and manage courses. Each course is associated with a specific teacher and contains learning materials, quizzes, and schedules.

5.2 Enrollment Management

Students can enroll in available courses. The system maintains many-to-many relationships between students and courses.

5.3 Quiz Management

Teachers can:

Create quizzes

Define availability duration

Upload quiz documents

Students can:

Access available quizzes

Submit quiz responses within specified time

5.4 Study Material Management

Teachers can upload course materials. Students can access and download relevant academic resources.

5.5 Session Scheduling

Teachers can schedule tutoring sessions with topics and dates. Students can view upcoming sessions.

6. Database Design Overview

The system is designed using a relational database structure.

Primary Entities

Users

Courses

Enrollments

Quizzes

Quiz Submissions

Materials

Schedules

Key Relationships

One Teacher → Many Courses

One Course → Many Enrollments

One Course → Many Quizzes

One Course → Many Materials

One Course → Many Scheduled Sessions

Database schema is implemented using Laravel Migrations.

7. Technology Stack
Component	Technology
Backend Framework	Laravel 10
Programming Language	PHP
Frontend	Blade Template Engine
Database	MySQL
Version Control	Git & GitHub
Development Server	Laravel Artisan
8. Installation and Setup Guide
Step 1: Clone the Repository
git clone https://github.com/your-username/tutoring-management-system.git
cd tutoring-management-system
Step 2: Install Dependencies
composer install
Step 3: Configure Environment File

Copy .env.example to .env and update database configuration:

DB_DATABASE=tutoring_system
DB_USERNAME=root
DB_PASSWORD=
Step 4: Generate Application Key
php artisan key:generate
Step 5: Run Migrations
php artisan migrate
Step 6: Start Development Server
php artisan serve

Open in browser:

http://127.0.0.1:8000
9. Software Engineering Practices Applied

MVC Architectural Pattern

Modular System Design

Database Normalization

Sprint-Based Development

Git Version Control Workflow

Separation of Concerns

Reusable Blade Layouts

10. Academic Context

This project is developed as part of a Software Engineering course requirement. The goal is to demonstrate:

Practical implementation of system design concepts

Framework-based development

Proper documentation and architectural planning

Application of UML modeling and database design principles

11. Future Enhancements

Planned improvements in upcoming sprints include:

Role-based dashboards

Performance tracking module

Automated grading system

Enhanced validation and security

Unit and feature testing

Deployment configuration

12. Project Status

Current Status:
🟢 Framework Initialized
🟢 Database Designed
🟢 Base Architecture Implemented
🟡 Functional Modules – In Development

# this is for testing navid_test branch
testing navid_test branch

# how to set up testing server for navid_test branch
1. Switch to navid_test branch
git checkout navid_test
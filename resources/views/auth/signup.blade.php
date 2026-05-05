@extends('layouts.app')

@section('content')
<style>
.signup-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
}

.signup-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    padding: 40px;
    width: 100%;
    max-width: 500px;
    position: relative;
    overflow: hidden;
}

.signup-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.signup-header {
    text-align: center;
    margin-bottom: 30px;
}

.signup-header h2 {
    color: #333;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.signup-header p {
    color: #666;
    font-size: 1rem;
    margin: 0;
}

.form-row {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
}

.form-row .form-group {
    flex: 1;
    margin-bottom: 0;
}

.form-group {
    margin-bottom: 25px;
    position: relative;
}

.form-group label {
    display: block;
    color: #333;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.form-control {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e1e5e9;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    background-color: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
}

select.form-control {
    cursor: pointer;
}

.btn-primary {
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.btn-primary:active {
    transform: translateY(0);
}

.alert {
    border-radius: 10px;
    border: none;
    margin-bottom: 25px;
}

.alert-danger {
    background-color: #fee;
    color: #c33;
    border-left: 4px solid #e74c3c;
}

.alert-success {
    background-color: #efe;
    color: #363;
    border-left: 4px solid #27ae60;
}

.login-link {
    text-align: center;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #e1e5e9;
}

.login-link p {
    color: #666;
    font-size: 0.95rem;
    margin: 0;
}

.login-link a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.login-link a:hover {
    color: #764ba2;
    text-decoration: underline;
}

.role-selector {
    position: relative;
}

.role-selector::after {
    content: '▼';
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #667eea;
    pointer-events: none;
}

@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
        gap: 0;
    }

    .signup-card {
        padding: 30px 20px;
        margin: 10px;
    }

    .signup-header h2 {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .signup-container {
        padding: 10px;
    }

    .signup-card {
        padding: 25px 15px;
    }
}
</style>

<div class="signup-container">
    <div class="signup-card">
        <div class="signup-header">
            <h2>Join StudyTime</h2>
            <p>Create your account to get started</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('signup') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email address" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Create password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password" required>
                </div>
            </div>

            <div class="form-group">
                <label for="role">I am a</label>
                <div class="role-selector">
                    <select name="role" id="role" class="form-control" required>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
        </div>
    </div>
</div>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Signup - Library System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
        }
        .login-card {
            border: 1px solid #d1d5db;
            border-radius: 15px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: #ffffff;
            max-width: 400px;
            width: 100%;
        }
        .card-header {
            background: #f9fafb;
            color: #1f2937;
            padding: 1.5rem;
            border-bottom: 1px solid #d1d5db;
            text-align: center;
        }
        .card-header h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .card-body {
            padding: 2rem;
        }
        .form-label {
            font-weight: 500;
            color: #374151;
        }
        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid #9ca3af;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background-color: #f9fafb;
        }
        .form-control:focus {
            border-color: #6b7280;
            box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.1);
            outline: none;
            background-color: #ffffff;
        }
        .btn-primary {
            background: #6b7280;
            border: none;
            color: #ffffff;
            padding: 0.75rem;
            font-weight: 500;
            border-radius: 8px;
            transition: background 0.3s ease, color 0.3s ease;
        }
        .btn-primary:hover {
            background: #4b5563;
            color: #f0f2f5;
        }
        .btn-outline-secondary {
            border-color: #9ca3af;
            color: #4b5563;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-outline-secondary:hover {
            background: #f3f4f6;
            color: #6b7280;
            border-color: #6b7280;
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 1.5rem;
            padding: 0.75rem;
            font-size: 0.9rem;
            border: 1px solid #f87171;
        }
        .alert-success {
            border-color: #34d399;
        }
        .alert ul {
            margin: 0;
            padding-left: 1rem;
        }
        .text-center a {
            text-decoration: none;
        }
        .text-center p {
            color: #4b5563;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="card-header">
            <h3>Student Signup</h3>
        </div>
        <div class="card-body">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success Message (e.g., after registration) -->
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('student.register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" name="age" value="{{ old('age') }}" required>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" required>{{ old('address') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="class" class="form-label">Class</label>
                    <input type="text" class="form-control" id="class" name="class" value="{{ old('class') }}" required>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
                <div class="text-center">
                    <p class="mb-2">Already have an account?</p>
                    <a href="{{ route('student.login') }}" class="btn btn-outline-secondary">Back to Login</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS (for potential future interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
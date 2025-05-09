<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Student Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <h4>Welcome, {{ $student->name }}!</h4>
                        <p>Email: {{ $student->email }}</p>
                        <p>Class: {{ $student->class }}</p>
                        <p>Phone: {{ $student->phone }}</p>
                        <p>Address: {{ $student->address }}</p>
                        <form method="POST" action="{{ route('student.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
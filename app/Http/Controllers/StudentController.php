<?php

namespace App\Http\Controllers;

use App\Models\student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = student::paginate(10);
        return view('student.index', compact('students'));
    }

    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:8',
            'gender' => 'required|string|in:male,female,other',
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'class' => 'nullable|string',
            'age' => 'nullable|integer',
        ]);

        student::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'class' => $validated['class'],
            'age' => $validated['age'],
        ]);

        // Redirect based on user role
        $route = auth()->check() && auth()->guard('web')->check() ? 'students.index' : 'student.students.index';
        return redirect()->route($route)->with('success', 'Student created successfully!');
    }

    public function show(student $student)
    {
        return response()->json($student);
    }

    public function edit(student $student)
    {
        return view('student.edit', compact('student'));
    }

    public function update(Request $request, student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'gender' => 'required|string|in:male,female,other',
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'class' => 'nullable|string',
            'age' => 'nullable|integer',
        ]);

        $student->update($validated);

        // Redirect based on user role
        $route = auth()->check() && auth()->guard('web')->check() ? 'students.index' : 'student.students.index';
        return redirect()->route($route)->with('success', 'Student updated successfully!');
    }

    public function destroy(student $student)
    {
        $student->delete();

        // Redirect based on user role
        $route = auth()->check() && auth()->guard('web')->check() ? 'students.index' : 'student.students.index';
        return redirect()->route($route)->with('success', 'Student deleted successfully!');
    }
}
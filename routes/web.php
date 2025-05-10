<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\AutherController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookIssueController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentBookController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->middleware('guest');
Route::post('/', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('change-password', [dashboardController::class, 'change_password_view'])->name('change_password_view');
    Route::post('change-password', [dashboardController::class, 'change_password'])->name('change_password');
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');

    // Author CRUD (converted to resource route)
    Route::resource('authors', AutherController::class);

    // Publisher CRUD (converted to resource route)
    Route::resource('publishers', PublisherController::class);

    // Category CRUD (converted to resource route)
    Route::resource('categories', CategoryController::class);

    // Books CRUD (converted to resource route)
    Route::resource('books', BookController::class);

    // Students CRUD with resource route
    Route::resource('students', StudentController::class);


    Route::get('/student/books', [StudentBookController::class, 'index'])->name('student.books.index');

    // Book Issues
    Route::get('/book_issue', [BookIssueController::class, 'index'])->name('book_issued');
    Route::get('/book-issue/create', [BookIssueController::class, 'create'])->name('book_issue.create');
    Route::get('/book-issue/edit/{id}', [BookIssueController::class, 'edit'])->name('book_issue.edit');
    Route::post('/book-issue/update/{id}', [BookIssueController::class, 'update'])->name('book_issue.update');
    Route::post('/book-issue/delete/{id}', [BookIssueController::class, 'destroy'])->name('book_issue.destroy');
    Route::post('/book-issue/create', [BookIssueController::class, 'store'])->name('book_issue.store');

    // Reports
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/reports/Date-Wise', [ReportsController::class, 'date_wise'])->name('reports.date_wise');
    Route::post('/reports/Date-Wise', [ReportsController::class, 'generate_date_wise_report'])->name('reports.date_wise_generate');
    Route::get('/reports/monthly-Wise', [ReportsController::class, 'month_wise'])->name('reports.month_wise');
    Route::post('/reports/monthly-Wise', [ReportsController::class, 'generate_month_wise_report'])->name('reports.month_wise_generate');
    Route::get('/reports/not-returned', [ReportsController::class, 'not_returned'])->name('reports.not_returned');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings');
});

// Student routes
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [StudentAuthController::class, 'login']);
    Route::get('/register', [StudentAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [StudentAuthController::class, 'register']);
    Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->middleware('student')->name('dashboard');
    Route::post('/transaction/{book}', [StudentDashboardController::class, 'transaction'])->name('transaction'); // Fixed route path

    // Students CRUD with resource route
    Route::resource('students', StudentController::class)->names([
        'index' => 'students.index',
        'create' => 'students.create',
        'store' => 'students.store',
        'show' => 'students.show',
        'edit' => 'students.edit',
        'update' => 'students.update',
        'destroy' => 'students.destroy',
    ])->parameters(['students' => 'student']);
});
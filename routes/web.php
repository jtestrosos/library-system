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

    // Author CRUD
    Route::resource('authors', AutherController::class);

    // Publisher CRUD
    Route::resource('publishers', PublisherController::class);

    // Category CRUD
    Route::resource('categories', CategoryController::class);

    // Books CRUD
    Route::resource('books', BookController::class);

    // Students CRUD
    Route::resource('students', StudentController::class);

    // Book Issues
    Route::resource('book_issues', BookIssueController::class)->names([
        'index' => 'book_issued',
        'create' => 'book_issue.create',
        'store' => 'book_issue.store',
        'show' => 'book_issue.show',
        'edit' => 'book_issue.edit',
        'update' => 'book_issue.update',
        'destroy' => 'book_issue.destroy',
    ]);

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

    // Student dashboard routes with middleware
    Route::group(['middleware' => ['auth:student']], function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/transaction/{bookId}/{action}', [StudentDashboardController::class, 'transactionConfirm'])->name('transaction.confirm');
        Route::post('/transaction/{bookId}', [StudentDashboardController::class, 'transaction'])->name('transaction');

        // Add books index route for students
        Route::get('/books', [StudentBookController::class, 'index'])->name('books.index');

        Route::resource('students', StudentController::class)->names([
            'index' => 'students.index',
            'create' => 'students.create',
            'store' => 'students.store',
            'show' => 'students.show',
            'edit' => 'students.edit',
            'update' => 'students.update',
            'delete' => 'students.delete',
        ])->parameters(['students' => 'student']);
    });
});
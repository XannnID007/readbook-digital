<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/preferences', [HomeController::class, 'setPreferences'])->name('preferences.set');
Route::get('/recommendations', [HomeController::class, 'recommendations'])->name('recommendations');

// Book Routes
Route::get('/books/{book:slug}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/{book:slug}/read', [BookController::class, 'read'])->name('books.read')->middleware('auth');
Route::post('/books/{book}/progress', [BookController::class, 'updateProgress'])->name('books.progress')->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// User Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/my-books', [UserController::class, 'myBooks'])->name('user.books');
    Route::get('/reading-history', [UserController::class, 'readingHistory'])->name('user.history');
    Route::get('/bookmarks', [UserController::class, 'bookmarks'])->name('user.bookmarks');

    // Bookmark Routes
    Route::post('/bookmark/{book}', [BookmarkController::class, 'toggle'])->name('bookmark.toggle');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Books Management
    Route::resource('books', AdminBookController::class);

    // Categories Management
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Users Management
    Route::resource('users', AdminUserController::class)->except(['create', 'store']);
});

<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/preferences', [HomeController::class, 'setPreferences'])->name('preferences.set');
Route::get('/recommendations', [HomeController::class, 'recommendations'])->name('recommendations');

// Search Routes
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Category Routes  
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Book Routes
Route::get('/books/{book:slug}', [BookController::class, 'show'])->name('books.show');
Route::middleware('auth')->group(function () {
    Route::get('/books/{book:slug}/read', [BookController::class, 'read'])->name('books.read');
    Route::post('/books/{book}/progress', [BookController::class, 'updateProgress'])->name('books.progress');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// User Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/my-books', [UserController::class, 'myBooks'])->name('user.books');
    Route::get('/reading-history', [UserController::class, 'readingHistory'])->name('user.history');
    Route::get('/bookmarks', [UserController::class, 'bookmarks'])->name('user.bookmarks');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.preferences');

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

// API Routes for AJAX calls
Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('/books/search', [App\Http\Controllers\Api\BookController::class, 'search'])->name('api.books.search');
    Route::get('/books/popular', [App\Http\Controllers\Api\BookController::class, 'popular'])->name('api.books.popular');
    Route::get('/books/latest', [App\Http\Controllers\Api\BookController::class, 'latest'])->name('api.books.latest');
});

// Fallback route untuk 404
Route::fallback(function () {
    return view('errors.404');
});

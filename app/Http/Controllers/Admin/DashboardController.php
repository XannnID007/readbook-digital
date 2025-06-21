<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use App\Models\ReadingHistory;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_categories' => Category::count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_readings' => ReadingHistory::count(),
        ];

        $recentBooks = Book::latest()->take(5)->with('category')->get();
        $popularBooks = Book::orderBy('views', 'desc')->take(5)->with('category')->get();
        $recentUsers = User::where('role', 'user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBooks', 'popularBooks', 'recentUsers'));
    }
}

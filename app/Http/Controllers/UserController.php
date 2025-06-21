<?php

namespace App\Http\Controllers;

use App\Models\ReadingHistory;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = auth()->user();

        $stats = [
            'books_read' => ReadingHistory::where('user_id', $user->id)->count(),
            'bookmarks' => Bookmark::where('user_id', $user->id)->count(),
            'reading_time' => ReadingHistory::where('user_id', $user->id)->count() * 30, // estimasi menit
        ];

        $recentlyRead = ReadingHistory::where('user_id', $user->id)
            ->with('book.category')
            ->latest('last_read_at')
            ->take(6)
            ->get();

        $bookmarks = Bookmark::where('user_id', $user->id)
            ->with('book.category')
            ->latest()
            ->take(6)
            ->get();

        return view('user.dashboard', compact('stats', 'recentlyRead', 'bookmarks'));
    }

    public function myBooks()
    {
        $readingHistory = ReadingHistory::where('user_id', auth()->id())
            ->with('book.category')
            ->latest('last_read_at')
            ->paginate(12);

        return view('user.books', compact('readingHistory'));
    }

    public function readingHistory()
    {
        $history = ReadingHistory::where('user_id', auth()->id())
            ->with('book.category')
            ->latest('last_read_at')
            ->paginate(20);

        return view('user.history', compact('history'));
    }

    public function bookmarks()
    {
        $bookmarks = Bookmark::where('user_id', auth()->id())
            ->with('book.category')
            ->latest()
            ->paginate(12);

        return view('user.bookmarks', compact('bookmarks'));
    }
}

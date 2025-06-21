<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function toggle(Book $book)
    {
        $user = auth()->user();

        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $message = 'Buku dihapus dari bookmark';
            $status = 'removed';
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'book_id' => $book->id
            ]);
            $message = 'Buku ditambahkan ke bookmark';
            $status = 'added';
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $status
            ]);
        }

        return back()->with('success', $message);
    }
}

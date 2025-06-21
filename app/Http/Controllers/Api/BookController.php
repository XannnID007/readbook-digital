<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');

        $books = Book::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('author', 'LIKE', "%{$query}%");
            })
            ->with('category')
            ->limit(10)
            ->get(['id', 'title', 'author', 'cover_image', 'category_id']);

        return response()->json($books);
    }

    public function popular()
    {
        $books = Book::where('is_active', true)
            ->orderBy('views', 'desc')
            ->with('category')
            ->limit(6)
            ->get();

        return response()->json($books);
    }

    public function latest()
    {
        $books = Book::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->with('category')
            ->limit(6)
            ->get();

        return response()->json($books);
    }
}

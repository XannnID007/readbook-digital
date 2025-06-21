<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $categoryId = $request->get('category');
        $sort = $request->get('sort', 'relevance');

        $books = Book::query()
            ->where('is_active', true)
            ->with(['category']);

        // Search by title, author, or description
        if ($query) {
            $books->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('author', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            });
        }

        // Filter by category
        if ($categoryId) {
            $books->where('category_id', $categoryId);
        }

        // Sort results
        switch ($sort) {
            case 'title':
                $books->orderBy('title');
                break;
            case 'author':
                $books->orderBy('author');
                break;
            case 'rating':
                $books->orderBy('rating', 'desc');
                break;
            case 'popular':
                $books->orderBy('views', 'desc');
                break;
            case 'newest':
                $books->orderBy('created_at', 'desc');
                break;
            default: // relevance
                if ($query) {
                    $books->orderByRaw("
                        CASE 
                            WHEN title LIKE '%{$query}%' THEN 1
                            WHEN author LIKE '%{$query}%' THEN 2
                            WHEN description LIKE '%{$query}%' THEN 3
                            ELSE 4
                        END
                    ");
                } else {
                    $books->orderBy('views', 'desc');
                }
                break;
        }

        $books = $books->paginate(12)->appends($request->query());
        $categories = Category::all();

        return view('search.index', compact('books', 'categories', 'query', 'categoryId', 'sort'));
    }
}

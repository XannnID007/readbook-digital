<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category, Request $request)
    {
        $sort = $request->get('sort', 'popular');

        $books = $category->books()
            ->where('is_active', true)
            ->with('category');

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
            case 'newest':
                $books->orderBy('created_at', 'desc');
                break;
            default: // popular
                $books->orderBy('views', 'desc');
                break;
        }

        $books = $books->paginate(12)->appends($request->query());

        return view('categories.show', compact('category', 'books', 'sort'));
    }
}

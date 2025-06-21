<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use App\Services\RecommendationService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function index()
    {
        $categories = Category::withCount('books')->get();
        $featuredBooks = Book::where('is_featured', true)
            ->where('is_active', true)
            ->with('category')
            ->take(6)
            ->get();

        $popularBooks = Book::where('is_active', true)
            ->orderBy('views', 'desc')
            ->with('category')
            ->take(8)
            ->get();

        return view('home', compact('categories', 'featuredBooks', 'popularBooks'));
    }

    public function setPreferences(Request $request)
    {
        $request->validate([
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id'
        ]);

        if (auth()->check()) {
            /** @var User $user */
            $user = auth()->user();
            $user->update([
                'preferences' => $request->categories
            ]);
        } else {
            session(['guest_preferences' => $request->categories]);
        }

        return redirect()->route('recommendations');
    }

    public function recommendations()
    {
        $preferences = auth()->check()
            ? auth()->user()->preferences
            : session('guest_preferences', []);

        if (empty($preferences)) {
            return redirect()->route('home')->with('error', 'Silakan pilih preferensi kategori terlebih dahulu.');
        }

        $recommendedBooks = $this->recommendationService->getRecommendations($preferences);

        return view('recommendations', compact('recommendedBooks'));
    }
}

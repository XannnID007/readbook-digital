<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\ReadingHistory;

class BookController extends Controller
{
    public function show(Book $book)
    {
        $book->load('category');
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('books.show', compact('book', 'relatedBooks'));
    }

    public function read(Book $book)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membaca buku.');
        }

        // Increment view count
        $book->increment('views');

        // Update or create reading history
        $history = ReadingHistory::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'book_id' => $book->id
            ],
            [
                'last_read_at' => now()
            ]
        );

        return view('books.read', compact('book', 'history'));
    }

    public function updateProgress(Request $request, Book $book)
    {
        // Log request untuk debugging
        Log::info('📖 Progress Update Request', [
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'page' => $request->page,
            'book_pages' => $book->pages
        ]);

        // Cek autentikasi
        if (!auth()->check()) {
            Log::warning('❌ Unauthorized access attempt');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validasi input
        $request->validate([
            'page' => 'required|integer|min:1|max:' . ($book->pages ?: 9999)
        ]);

        try {
            // Update atau create reading history
            $history = ReadingHistory::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'book_id' => $book->id
                ],
                [
                    'last_page' => $request->page,
                    'last_read_at' => now(),
                ]
            );

            // Log success
            Log::info('✅ Progress updated successfully', [
                'history_id' => $history->id,
                'page' => $history->last_page,
                'user_id' => $history->user_id
            ]);

            // Calculate progress
            $progressPercentage = $book->pages > 0 ? round(($request->page / $book->pages) * 100, 1) : 0;

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Progress berhasil disimpan',
                'data' => [
                    'page' => (int) $request->page,
                    'total_pages' => (int) $book->pages,
                    'progress_percentage' => $progressPercentage,
                    'remaining_pages' => max(0, $book->pages - $request->page),
                    'updated_at' => $history->updated_at->format('Y-m-d H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            // Log error
            Log::error('❌ Progress update failed', [
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            // Return error response
            return response()->json([
                'success' => false,
                'error' => 'Gagal menyimpan progress',
                'message' => config('app.debug') ? $e->getMessage() : 'Terjadi kesalahan sistem'
            ], 500);
        }
    }
}

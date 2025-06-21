<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'preferences',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'preferences' => 'array',
    ];

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Get user's reading histories
     */
    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class);
    }

    /**
     * Get user's bookmarks
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Get user's favorite category based on reading history
     *
     * @return string|null
     */
    public function getFavoriteCategoryAttribute()
    {
        $categoryCount = $this->readingHistories()
            ->join('books', 'reading_histories.book_id', '=', 'books.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, COUNT(*) as count')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('count', 'desc')
            ->first();

        return $categoryCount ? $categoryCount->name : null;
    }

    /**
     * Get total reading time estimate in minutes
     *
     * @return int
     */
    public function getReadingTimeAttribute()
    {
        // Estimate 2 minutes per page
        $totalPages = $this->readingHistories()
            ->join('books', 'reading_histories.book_id', '=', 'books.id')
            ->sum('reading_histories.last_page');

        return $totalPages * 2; // 2 minutes per page estimate
    }

    /**
     * Get reading progress percentage for a specific book
     *
     * @param int $bookId
     * @return float
     */
    public function getReadingProgress($bookId)
    {
        $history = $this->readingHistories()
            ->where('book_id', $bookId)
            ->first();

        if (!$history) {
            return 0;
        }

        $book = \App\Models\Book::find($bookId);
        if (!$book) {
            return 0;
        }

        return round(($history->last_page / $book->pages) * 100, 2);
    }

    /**
     * Check if user has bookmarked a specific book
     *
     * @param int $bookId
     * @return bool
     */
    public function hasBookmarked($bookId)
    {
        return $this->bookmarks()->where('book_id', $bookId)->exists();
    }

    /**
     * Get recently read books
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentlyReadBooks($limit = 5)
    {
        return $this->readingHistories()
            ->with('book.category')
            ->latest('last_read_at')
            ->take($limit)
            ->get()
            ->pluck('book');
    }

    /**
     * Get user statistics
     *
     * @return array
     */
    public function getStatsAttribute()
    {
        return [
            'books_read' => $this->readingHistories()->count(),
            'bookmarks' => $this->bookmarks()->count(),
            'reading_time' => $this->reading_time,
            'favorite_category' => $this->favorite_category,
            'total_pages_read' => $this->readingHistories()
                ->join('books', 'reading_histories.book_id', '=', 'books.id')
                ->sum('reading_histories.last_page'),
        ];
    }

    /**
     * Scope for admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope for regular users
     */
    public function scopeUsers($query)
    {
        return $query->where('role', 'user');
    }
}

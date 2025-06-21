<div class="card book-card h-100">
    <div class="position-relative">
        @if ($book->cover_image)
            <img src="{{ Storage::url($book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}"
                style="height: 250px; object-fit: cover;">
        @else
            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                <i class="fas fa-book fa-3x text-muted"></i>
            </div>
        @endif

        @if ($book->is_featured ?? false)
            <span class="badge bg-warning position-absolute top-0 end-0 m-2">
                <i class="fas fa-star"></i> Unggulan
            </span>
        @endif

        <div class="position-absolute top-0 start-0 m-2">
            <span class="badge bg-primary">{{ $book->category->name }}</span>
        </div>

        @auth
            <button class="btn btn-outline-light position-absolute bottom-0 end-0 m-2"
                onclick="toggleBookmark({{ $book->id }})">
                <i class="fas fa-bookmark {{ $book->isBookmarkedBy(auth()->id()) ? 'text-warning' : '' }}"></i>
            </button>
        @endauth
    </div>

    <div class="card-body">
        <h6 class="card-title">{{ Str::limit($book->title, 50) }}</h6>
        <p class="text-muted small">oleh {{ $book->author }}</p>
        <p class="card-text small">{{ Str::limit($book->description, 80) }}</p>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-warning small">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star{{ $i <= $book->rating ? '' : '-o' }}"></i>
                @endfor
                <small class="text-muted">({{ $book->rating }})</small>
            </div>
            <small class="text-muted">
                <i class="fas fa-eye"></i> {{ $book->views }}
            </small>
        </div>

        <div class="d-grid gap-2">
            <a href="{{ route('books.show', $book->slug) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-eye"></i> Lihat Detail
            </a>
            <a href="{{ route('books.read', $book->slug) }}" class="btn btn-outline-success btn-sm">
                <i class="fas fa-book-open"></i> Baca Sekarang
            </a>
        </div>
    </div>
</div>

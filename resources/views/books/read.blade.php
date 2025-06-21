@extends('layouts.reader')

@push('styles')
    <style>
        /* Reading container - full viewport */
        .reading-container {
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* Enhanced Sidebar */
        .reading-sidebar {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(248, 249, 250, 0.95));
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 107, 53, 0.1);
            box-shadow: 2px 0 20px rgba(255, 107, 53, 0.05);
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            min-height: 120px;
            display: flex;
            align-items: center;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 0.5;
            }

            50% {
                opacity: 1;
            }
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white !important;
            border-radius: 10px;
            padding: 0.75rem;
            transition: all 0.3s ease;
            text-decoration: none;
            backdrop-filter: blur(10px);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 45px;
            min-height: 45px;
            position: relative;
            z-index: 2;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white !important;
            transform: translateX(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .book-title-header {
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .book-title-header h6 {
            color: white !important;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
            line-height: 1.3;
        }

        .book-title-header small {
            color: rgba(255, 255, 255, 0.85) !important;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .progress-section {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 1.5rem;
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .progress-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .progress-title i {
            color: var(--primary-orange);
        }

        .progress-badge {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }

        .progress-bar-elegant {
            height: 12px;
            border-radius: 6px;
            background: rgba(255, 107, 53, 0.2);
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-orange), var(--secondary-orange));
            border-radius: 6px;
            transition: width 0.5s ease;
            position: relative;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
        }

        .page-info {
            color: var(--text-muted);
            font-weight: 500;
        }

        .remaining-pages {
            color: #28a745;
            font-weight: 600;
        }

        .navigation-section {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 1.5rem;
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .navigation-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .navigation-title i {
            color: #ffc107;
        }

        .page-input-group {
            background: var(--soft-gray);
            border-radius: 12px;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 2px solid rgba(255, 107, 53, 0.1);
            transition: all 0.3s ease;
        }

        .page-input-group:focus-within {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .page-input {
            background: transparent;
            border: none;
            outline: none;
            font-weight: 600;
            color: var(--text-dark);
        }

        .page-go-btn {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border: none;
            border-radius: 8px;
            color: white;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .page-go-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }

        .nav-buttons {
            display: grid;
            gap: 0.75rem;
        }

        .nav-btn {
            background: transparent;
            border: 2px solid var(--primary-orange);
            border-radius: 12px;
            color: var(--primary-orange);
            padding: 0.75rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-btn:hover:not(:disabled) {
            background: var(--primary-orange);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }

        .nav-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .book-info-section {
            border-top: 2px solid rgba(255, 107, 53, 0.1);
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .book-info-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 107, 53, 0.05);
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .book-cover-small {
            width: 50px;
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .book-cover-placeholder {
            width: 50px;
            height: 70px;
            background: var(--soft-gray);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
        }

        .book-details h6 {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .book-author {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .book-rating {
            color: #ffc107;
        }

        /* Reader Container */
        .reader-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .reader-toolbar {
            background: var(--warm-white);
            border-bottom: 1px solid rgba(255, 107, 53, 0.1);
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 10px rgba(255, 107, 53, 0.05);
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .toolbar-page-info {
            color: var(--text-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .toolbar-page-info i {
            color: var(--primary-orange);
        }

        .toolbar-progress {
            width: 200px;
            height: 8px;
            background: rgba(255, 107, 53, 0.2);
            border-radius: 4px;
            overflow: hidden;
        }

        .toolbar-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-orange), var(--secondary-orange));
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .toolbar-btn {
            background: transparent;
            border: 2px solid var(--primary-orange);
            border-radius: 8px;
            color: var(--primary-orange);
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .toolbar-btn:hover {
            background: var(--primary-orange);
            color: white;
            transform: translateY(-1px);
        }

        .pdf-viewer {
            flex: 1;
            background: #f5f5f5;
            position: relative;
            overflow: hidden;
        }

        .pdf-embed {
            width: 100%;
            height: 100%;
            border: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .pdf-embed.loaded {
            opacity: 1;
        }

        .loading-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 10;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 107, 53, 0.2);
            border-left: 4px solid var(--primary-orange);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Fullscreen mode */
        .reader-container.fullscreen {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 9999 !important;
            background: white !important;
        }

        /* Save indicator */
        .save-indicator {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 1rem 2rem;
            border-radius: 25px;
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
            z-index: 1051;
            opacity: 0;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .save-indicator.show {
            opacity: 1;
            transform: translateX(-50%) translateY(10px);
        }

        /* Floating action buttons */
        .floating-actions {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            z-index: 1050;
        }

        .floating-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }

        .floating-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
        }

        .floating-btn.bookmark {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
        }

        .floating-btn.bookmark.active {
            background: linear-gradient(135deg, #fd7e14, #ffc107);
        }

        .floating-btn.help {
            background: linear-gradient(135deg, #17a2b8, #007bff);
        }

        /* Toast notifications */
        .reader-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 300px;
            border-radius: 15px;
            z-index: 9999;
            animation: slideInRight 0.3s ease;
            backdrop-filter: blur(20px);
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .reading-sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 90%;
                max-width: 350px;
                z-index: 1055;
                transition: left 0.3s ease;
            }

            .reading-sidebar.show {
                left: 0;
            }

            .reader-container {
                margin-left: 0 !important;
            }

            .toolbar-progress {
                width: 120px;
            }

            .floating-actions {
                bottom: 1rem;
                right: 1rem;
                gap: 0.75rem;
            }

            .floating-btn {
                width: 50px;
                height: 50px;
                font-size: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Same content as before, no changes needed in the HTML structure -->
    <div class="reading-container">
        <div class="row g-0 h-100">
            <!-- Reading Sidebar -->
            <div class="col-md-3 reading-sidebar" id="readingSidebar">
                <!-- Sidebar Header -->
                <div class="sidebar-header">
                    <div class="d-flex align-items-center w-100">
                        <a href="{{ route('books.show', $book->slug) }}" class="back-btn me-3" title="Kembali ke detail buku">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <div class="book-title-header flex-grow-1">
                            <h6 class="mb-1 fw-bold">{{ Str::limit($book->title, 30) }}</h6>
                            <small>oleh {{ $book->author }}</small>
                        </div>
                    </div>
                </div>

                <!-- Rest of the sidebar content remains the same -->
                <!-- Reading Progress -->
                <div class="progress-section">
                    <div class="progress-header">
                        <h6 class="progress-title mb-0">
                            <i class="fas fa-chart-line"></i>
                            <span>Progress Membaca</span>
                        </h6>
                        <span class="progress-badge" id="progressBadge">
                            {{ round((($history->last_page ?? 1) / $book->pages) * 100) }}%
                        </span>
                    </div>
                    <div class="progress-bar-elegant mb-3">
                        <div class="progress-fill" id="progressFill"
                            style="width: {{ (($history->last_page ?? 1) / $book->pages) * 100 }}%">
                        </div>
                    </div>
                    <div class="progress-info">
                        <span class="page-info" id="pageInfo">
                            Halaman {{ $history->last_page ?? 1 }} dari {{ $book->pages }}
                        </span>
                        <span class="remaining-pages" id="remainingPages">
                            {{ $book->pages - ($history->last_page ?? 1) }} tersisa
                        </span>
                    </div>
                </div>

                <!-- Page Navigation -->
                <div class="navigation-section">
                    <h6 class="navigation-title">
                        <i class="fas fa-bookmark"></i>
                        <span>Navigasi Halaman</span>
                    </h6>
                    <div class="page-input-group d-flex align-items-center">
                        <i class="fas fa-file-alt text-muted me-2"></i>
                        <input type="number" class="page-input flex-grow-1" id="pageInput" min="1"
                            max="{{ $book->pages }}" value="{{ $history->last_page ?? 1 }}" placeholder="Halaman">
                        <button class="page-go-btn ms-2" onclick="goToPage()" title="Pergi ke halaman">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>

                    <div class="nav-buttons">
                        <button class="nav-btn" id="prevPageBtn" onclick="previousPage()"
                            {{ ($history->last_page ?? 1) <= 1 ? 'disabled' : '' }}>
                            <i class="fas fa-chevron-left me-2"></i>Halaman Sebelumnya
                        </button>
                        <button class="nav-btn" id="nextPageBtn" onclick="nextPage()"
                            {{ ($history->last_page ?? 1) >= $book->pages ? 'disabled' : '' }}>
                            Halaman Selanjutnya<i class="fas fa-chevron-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Book Info -->
                <div class="book-info-section">
                    <div class="book-info-card">
                        @if ($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                class="book-cover-small">
                        @else
                            <div class="book-cover-placeholder">
                                <i class="fas fa-book"></i>
                            </div>
                        @endif
                        <div class="book-details flex-grow-1">
                            <h6>{{ $book->title }}</h6>
                            <div class="book-author">{{ $book->author }}</div>
                            <div class="book-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= ($book->rating ?? 0) ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PDF Reader -->
            <div class="col-md-9 reader-container" id="readerContainer">
                <!-- Top Toolbar -->
                <div class="reader-toolbar d-flex justify-content-between align-items-center">
                    <div class="toolbar-left">
                        <span class="toolbar-page-info" id="toolbarPageInfo">
                            <i class="fas fa-book-open"></i>
                            <span>Halaman {{ $history->last_page ?? 1 }} / {{ $book->pages }}</span>
                        </span>
                        <div class="toolbar-progress">
                            <div class="toolbar-progress-fill" id="toolbarProgressFill"
                                style="width: {{ (($history->last_page ?? 1) / $book->pages) * 100 }}%">
                            </div>
                        </div>
                    </div>
                    <div class="toolbar-right">
                        <button class="toolbar-btn d-md-none" onclick="toggleSidebar()" title="Toggle sidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                        <button class="toolbar-btn" id="fullscreenBtn" onclick="toggleFullscreen()"
                            title="Mode Layar Penuh">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>

                <!-- PDF Viewer -->
                <div class="pdf-viewer">
                    <!-- Loading Indicator -->
                    <div class="loading-overlay" id="loadingIndicator">
                        <div class="loading-spinner"></div>
                        <div class="text-muted fw-medium">Memuat buku...</div>
                    </div>

                    <!-- PDF Embed -->
                    <iframe id="pdfEmbed" class="pdf-embed"
                        src="{{ Storage::url($book->pdf_file) }}#page={{ $history->last_page ?? 1 }}&zoom=100&toolbar=0&navpanes=0&scrollbar=1">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Indicator -->
    <div id="saveIndicator" class="save-indicator">
        <i class="fas fa-check me-2"></i>Progress tersimpan otomatis
    </div>

    <!-- Floating Action Buttons -->
    <div class="floating-actions" id="floatingActions">
        <button class="floating-btn bookmark {{ $book->isBookmarkedBy(auth()->id()) ? 'active' : '' }}"
            onclick="toggleBookmark({{ $book->id }})" title="Bookmark">
            <i class="fas fa-bookmark" id="floatingBookmarkIcon"></i>
        </button>
        <button class="floating-btn help" onclick="showKeyboardShortcuts()" title="Bantuan">
            <i class="fas fa-question"></i>
        </button>
    </div>
@endsection

@push('scripts')
    <script>
        // Global variables
        let currentPage = {{ $history->last_page ?? 1 }};
        const totalPages = {{ $book->pages }};
        const bookId = {{ $book->id }};
        let autoSaveInterval;
        let isFullscreen = false;

        // CSRF Token
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        console.log('📚 Reader Initialized:', {
            currentPage,
            totalPages,
            bookId
        });

        // Initialize when document ready
        $(document).ready(function() {
            console.log('🚀 Document ready, initializing reader...');

            initializePDFReader();
            initializeKeyboardShortcuts();
            initializeTouchGestures();
            setupPageInput();
            startAutoSave();
            updateNavigationButtons();

            console.log('✅ Reader initialization complete');
        });

        // Initialize PDF Reader
        function initializePDFReader() {
            const pdfEmbed = document.getElementById('pdfEmbed');
            const loadingIndicator = document.getElementById('loadingIndicator');

            if (!pdfEmbed || !loadingIndicator) {
                console.error('❌ PDF elements not found');
                return;
            }

            console.log('📄 Initializing PDF reader to page:', currentPage);

            // Show PDF and hide loading after iframe loads
            pdfEmbed.onload = function() {
                console.log('✅ PDF loaded successfully');
                loadingIndicator.style.display = 'none';
                pdfEmbed.classList.add('loaded');
                showToast('Buku berhasil dimuat', 'success', 2000);
            };

            // Handle error
            pdfEmbed.onerror = function() {
                console.error('❌ PDF failed to load');
                loadingIndicator.innerHTML = `
            <div class="text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                <h5 class="text-danger">Gagal Memuat PDF</h5>
                <a href="{{ Storage::url($book->pdf_file) }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-external-link-alt me-1"></i>Buka di Tab Baru
                </a>
            </div>
        `;
            };

            // Fallback timeout
            setTimeout(() => {
                if (loadingIndicator.style.display !== 'none') {
                    console.log('⏱️ Loading timeout, showing PDF anyway');
                    loadingIndicator.style.display = 'none';
                    pdfEmbed.classList.add('loaded');
                }
            }, 3000);
        }

        // Progress tracking
        function updateProgress(page) {
            console.log('💾 Updating progress to page:', page);

            if (!page || page < 1 || page > totalPages) {
                console.warn('⚠️ Invalid page:', page);
                return;
            }

            $.ajax({
                url: '{{ route('books.progress', $book) }}',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    page: page
                },
                success: function(response) {
                    console.log('✅ Progress saved:', response);
                    updateProgressUI(page);
                    showSaveIndicator();
                },
                error: function(xhr, status, error) {
                    console.error('❌ Failed to save progress:', {
                        status: xhr.status,
                        error: error
                    });
                    showToast('Gagal menyimpan progress', 'error');
                }
            });
        }

        // Update UI elements
        function updateProgressUI(page) {
            const percentage = Math.round((page / totalPages) * 100);

            // Update progress bars
            $('#progressFill, #toolbarProgressFill').css('width', percentage + '%');

            // Update text elements
            $('#pageInfo').text(`Halaman ${page} dari ${totalPages}`);
            $('#toolbarPageInfo span').text(`Halaman ${page} / ${totalPages}`);
            $('#remainingPages').text(`${totalPages - page} tersisa`);
            $('#progressBadge').text(`${percentage}%`);
            $('#pageInput').val(page);

            updateNavigationButtons();
            document.title = `${page}/${totalPages} - {{ $book->title }}`;
        }

        // Navigation functions
        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                updatePDFPage(currentPage);
                updateProgress(currentPage);
                showToast(`Halaman ${currentPage}`, 'info', 1500);
            } else {
                showToast('Ini adalah halaman pertama', 'warning');
            }
        }

        function goToPage() {
            const page = parseInt($('#pageInput').val());

            if (isNaN(page) || page < 1 || page > totalPages) {
                showToast(`Halaman harus antara 1 dan ${totalPages}`, 'warning');
                $('#pageInput').val(currentPage).focus().select();
                return;
            }

            if (page === currentPage) {
                showToast('Anda sudah berada di halaman ini', 'info');
                return;
            }

            currentPage = page;
            updatePDFPage(currentPage);
            updateProgress(currentPage);
            showToast(`Menuju halaman ${page}`, 'info', 2000);
        }

        function updatePDFPage(page) {
            const pdfEmbed = document.getElementById('pdfEmbed');
            if (pdfEmbed) {
                const baseUrl = '{{ Storage::url($book->pdf_file) }}';
                pdfEmbed.src = `${baseUrl}#page=${page}&zoom=100&toolbar=0&navpanes=0&scrollbar=1`;
                console.log('📄 Updated PDF to page:', page);
            }
        }

        function updateNavigationButtons() {
            $('#prevPageBtn').prop('disabled', currentPage <= 1);
            $('#nextPageBtn').prop('disabled', currentPage >= totalPages);
        }

        // UI functions
        function toggleFullscreen() {
            const container = $('#readerContainer');
            const sidebar = $('#readingSidebar');
            const floatingActions = $('#floatingActions');
            const btn = $('#fullscreenBtn');

            if (!isFullscreen) {
                container.addClass('fullscreen');
                sidebar.hide();
                floatingActions.hide();
                btn.html('<i class="fas fa-compress"></i>').attr('title', 'Keluar Layar Penuh');
                isFullscreen = true;
                showToast('Mode layar penuh aktif (ESC untuk keluar)', 'info', 3000);
            } else {
                container.removeClass('fullscreen');
                sidebar.show();
                floatingActions.show();
                btn.html('<i class="fas fa-expand"></i>').attr('title', 'Mode Layar Penuh');
                isFullscreen = false;
                showToast('Mode layar penuh dinonaktifkan', 'info', 2000);
            }
        }

        function toggleSidebar() {
            const sidebar = $('#readingSidebar');
            sidebar.toggleClass('show');
        }

        // Bookmark function
        function toggleBookmark(bookId) {
            const floatingBtn = $('.floating-btn.bookmark');
            const floatingIcon = $('#floatingBookmarkIcon');

            floatingIcon.removeClass().addClass('fas fa-spinner fa-spin');

            $.ajax({
                url: '{{ route('bookmark.toggle', ':id') }}'.replace(':id', bookId),
                type: 'POST',
                data: {
                    _token: csrfToken
                },
                success: function(response) {
                    const iconClass = 'fas fa-bookmark';

                    floatingIcon.removeClass().addClass(iconClass);

                    if (response.status === 'added') {
                        floatingBtn.addClass('active');
                        showToast(response.message, 'success');
                    } else {
                        floatingBtn.removeClass('active');
                        showToast(response.message, 'info');
                    }
                },
                error: function() {
                    showToast('Gagal mengubah bookmark', 'error');
                    floatingIcon.removeClass().addClass('fas fa-bookmark');
                }
            });
        }

        // Auto-save
        function startAutoSave() {
            setInterval(() => {
                if (currentPage > 0) {
                    updateProgress(currentPage);
                }
            }, 30000);
            console.log('⏰ Auto-save started');
        }

        function showSaveIndicator() {
            const indicator = $('#saveIndicator');
            indicator.addClass('show');
            setTimeout(() => {
                indicator.removeClass('show');
            }, 2000);
        }

        // Toast notifications
        function showToast(message, type = 'info', duration = 3000) {
            const toastClass = {
                success: 'bg-success',
                error: 'bg-danger',
                warning: 'bg-warning',
                info: 'bg-info'
            };

            const iconClass = {
                success: 'fa-check-circle',
                error: 'fa-times-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };

            $('.reader-toast').remove();

            const toast = $(`
        <div class="toast show reader-toast ${toastClass[type]} text-white">
            <div class="toast-body d-flex align-items-center">
                <i class="fas ${iconClass[type]} me-2"></i>
                <span class="flex-grow-1">${message}</span>
                <button type="button" class="btn-close btn-close-white ms-2" onclick="$(this).closest('.toast').remove()"></button>
            </div>
        </div>
    `);

            $('body').append(toast);

            setTimeout(() => {
                toast.fadeOut(() => toast.remove());
            }, duration);
        }

        // Page input setup
        function setupPageInput() {
            $('#pageInput').on('input', function() {
                let value = parseInt($(this).val());
                if (isNaN(value) || value < 1) {
                    $(this).val('');
                } else if (value > totalPages) {
                    $(this).val(totalPages);
                    showToast(`Halaman maksimum adalah ${totalPages}`, 'warning');
                }
            }).on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    goToPage();
                }
            }).on('blur', function() {
                if (!$(this).val()) {
                    $(this).val(currentPage);
                }
            }).on('focus', function() {
                $(this).select();
            });
        }

        // Keyboard shortcuts
        function initializeKeyboardShortcuts() {
            $(document).on('keydown', function(e) {
                if ($(e.target).is('input, textarea, select')) return;

                switch (e.which) {
                    case 37: // Left arrow
                        e.preventDefault();
                        previousPage();
                        break;
                    case 39: // Right arrow
                        e.preventDefault();
                        nextPage();
                        break;
                    case 122: // F11
                        e.preventDefault();
                        toggleFullscreen();
                        break;
                    case 27: // Escape
                        if (isFullscreen) {
                            e.preventDefault();
                            toggleFullscreen();
                        }
                        break;
                }

                if (e.ctrlKey) {
                    switch (e.which) {
                        case 83: // Ctrl+S
                            e.preventDefault();
                            updateProgress(currentPage);
                            showSaveIndicator();
                            break;
                        case 72: // Ctrl+H
                            e.preventDefault();
                            showKeyboardShortcuts();
                            break;
                        case 66: // Ctrl+B
                            e.preventDefault();
                            toggleBookmark(bookId);
                            break;
                    }
                }
            });
        }

        // Touch gestures
        function initializeTouchGestures() {
            let touchStartX = 0;
            let touchEndX = 0;

            $('#pdfEmbed').on('touchstart', function(e) {
                touchStartX = e.originalEvent.changedTouches[0].screenX;
            }).on('touchend', function(e) {
                touchEndX = e.originalEvent.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                const swipeThreshold = 50;
                const difference = touchStartX - touchEndX;

                if (Math.abs(difference) > swipeThreshold) {
                    if (difference > 0) {
                        nextPage(); // Swipe left - next page
                    } else {
                        previousPage(); // Swipe right - previous page
                    }
                }
            }
        }

        // Keyboard shortcuts help modal
        function showKeyboardShortcuts() {
            const helpModal = `
        <div class="modal fade" id="shortcutsModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange)); color: white;">
                        <h5 class="modal-title">
                            <i class="fas fa-keyboard me-2"></i>Bantuan Navigasi & Shortcut
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-keyboard me-2"></i>Keyboard Shortcuts
                                </h6>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Halaman sebelumnya</span>
                                        <kbd class="bg-primary">←</kbd>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Halaman selanjutnya</span>
                                        <kbd class="bg-primary">→</kbd>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Toggle layar penuh</span>
                                        <kbd class="bg-primary">F11</kbd>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Keluar layar penuh</span>
                                        <kbd class="bg-secondary">ESC</kbd>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Simpan progress</span>
                                        <kbd class="bg-success">Ctrl+S</kbd>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Toggle bookmark</span>
                                        <kbd class="bg-warning">Ctrl+B</kbd>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-mobile-alt me-2"></i>Mobile & Touch
                                </h6>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item">
                                        <strong class="text-primary">Swipe kiri:</strong> Halaman selanjutnya
                                    </div>
                                    <div class="list-group-item">
                                        <strong class="text-primary">Swipe kanan:</strong> Halaman sebelumnya
                                    </div>
                                    <div class="list-group-item">
                                        <strong class="text-primary">Tap floating buttons:</strong> Navigasi cepat
                                    </div>
                                </div>
                                
                                <h6 class="text-success mt-4 mb-3">
                                    <i class="fas fa-lightbulb me-2"></i>Tips Membaca
                                </h6>
                                <ul class="list-unstyled small">
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Progress tersimpan otomatis setiap 30 detik
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Gunakan mode layar penuh untuk fokus maksimal
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Bookmark buku untuk akses cepat nanti
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Ketik nomor halaman untuk lompat langsung
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                            <i class="fas fa-check me-1"></i>Mengerti, Mulai Membaca!
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

            $('#shortcutsModal').remove();
            $('body').append(helpModal);

            const modal = new bootstrap.Modal(document.getElementById('shortcutsModal'));
            modal.show();

            $('#shortcutsModal').on('hidden.bs.modal', function() {
                $(this).remove();
            });
        }

        // Cleanup
        $(window).on('beforeunload', function() {
            if (autoSaveInterval) {
                clearInterval(autoSaveInterval);
            }
            updateProgress(currentPage);
        });

        // Mobile sidebar overlay
        $(document).on('click', function(e) {
            const sidebar = $('#readingSidebar');
            const isMobile = window.innerWidth <= 768;

            if (isMobile && sidebar.hasClass('show') && !sidebar[0].contains(e.target) && !$(e.target).closest(
                    '.toolbar-btn').length) {
                sidebar.removeClass('show');
            }
        });

        // Enhanced floating button interactions
        $(document).ready(function() {
            $('.floating-btn').hover(
                function() {
                    $(this).css('transform', 'translateY(-3px) scale(1.05)');
                },
                function() {
                    $(this).css('transform', 'translateY(0) scale(1)');
                }
            );

            // Add ripple effect to floating buttons
            $('.floating-btn').on('click', function(e) {
                const $this = $(this);
                const ripple = $('<span class="ripple"></span>');

                $this.append(ripple);

                ripple.css({
                    'position': 'absolute',
                    'border-radius': '50%',
                    'background': 'rgba(255, 255, 255, 0.6)',
                    'transform': 'scale(0)',
                    'animation': 'ripple 0.6s linear',
                    'left': '50%',
                    'top': '50%',
                    'width': '100%',
                    'height': '100%',
                    'margin-left': '-50%',
                    'margin-top': '-50%'
                });

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add ripple animation to CSS
        const style = document.createElement('style');
        style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
    
    .floating-btn {
        position: relative;
        overflow: hidden;
    }
`;
        document.head.appendChild(style);

        // Test progress function after page load
        setTimeout(() => {
            console.log('🧪 Testing progress function...');
            updateProgress(currentPage);
        }, 5000);
    </script>
@endpush

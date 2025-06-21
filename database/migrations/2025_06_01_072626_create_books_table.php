<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author');
            $table->text('description');
            $table->string('cover_image')->nullable();
            $table->string('pdf_file');
            $table->integer('pages')->default(0);
            $table->year('publication_year');
            $table->string('isbn')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->integer('views')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

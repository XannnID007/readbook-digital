<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Fiksi',
                'description' => 'Buku-buku cerita fiksi dan novel',
                'icon' => 'book-open'
            ],
            [
                'name' => 'Teknologi',
                'description' => 'Buku tentang teknologi dan pemrograman',
                'icon' => 'cpu'
            ],
            [
                'name' => 'Pendidikan',
                'description' => 'Buku-buku edukatif dan pembelajaran',
                'icon' => 'graduation-cap'
            ],
            [
                'name' => 'Horror',
                'description' => 'Buku-buku bergenre horor dan thriller',
                'icon' => 'ghost'
            ],
            [
                'name' => 'Romance',
                'description' => 'Buku-buku bergenre romance dan cinta',
                'icon' => 'heart'
            ],
            [
                'name' => 'Biografi',
                'description' => 'Buku biografi dan autobiografi',
                'icon' => 'user'
            ],
            [
                'name' => 'Sejarah',
                'description' => 'Buku-buku sejarah dan dokumenter',
                'icon' => 'clock'
            ],
            [
                'name' => 'Sains',
                'description' => 'Buku-buku sains dan penelitian',
                'icon' => 'flask'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

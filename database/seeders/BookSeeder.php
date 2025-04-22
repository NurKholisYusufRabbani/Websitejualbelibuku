<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run()
    {
        DB::table('books')->insert([
            [
                'judul' => 'Belajar Laravel dari Nol',
                'penulis' => 'John Doe',
                'harga' => 150000,
                'kategori_id' => 1,
                'stok' => 10,
                'deskripsi' => 'Panduan lengkap Laravel untuk pemula.',
                'cover_image' => 'default.jpg'
            ],
            [
                'judul' => 'Mastering PHP OOP',
                'penulis' => 'Jane Smith',
                'harga' => 120000,
                'kategori_id' => 2,
                'stok' => 5,
                'deskripsi' => 'Pelajari PHP OOP dengan mudah dan cepat.',
                'cover_image' => 'default.jpg'
            ],
            [
                'judul' => 'Clean Code',
                'penulis' => 'Robert C. Martin',
                'harga' => 200000,
                'kategori_id' => 3,
                'stok' => 15,
                'deskripsi' => 'Buku wajib buat developer yang ingin menulis kode bersih.',
                'cover_image' => 'default.jpg'
            ]
        ]);
    }
}

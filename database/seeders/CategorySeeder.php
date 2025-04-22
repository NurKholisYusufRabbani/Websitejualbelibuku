<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['nama_kategori' => 'Programming'],
            ['nama_kategori' => 'Software Engineering'],
            ['nama_kategori' => 'Computer Science'],
        ]);
    }
}

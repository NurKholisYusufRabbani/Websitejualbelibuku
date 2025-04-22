<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
        ]); // <-- Tambahin tanda tutup kurung ini
    }
}
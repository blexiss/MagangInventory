<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $this->call([
        CategorySeeder::class,
        SubcategorySeeder::class,
        ItemSeeder::class,
    ]);
}

}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Printing'],
            ['name' => 'Monitoring'],
            ['name' => 'Networking'],
            ['name' => 'Workstation'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategorySeeder extends Seeder
{
    public function run()
    {
        $subcategories = [
            'Printing' => ['Printer', 'Paper', 'Cartridge'],
            'Monitoring' => ['CCTV', 'Coaxial'],
            'Networking' => ['Router', 'Switch', 'AP', 'LAN'],
            'Workstation' => ['Monitor', 'Keyboard', 'Mouse', 'PC'],
        ];

        foreach ($subcategories as $categoryName => $subs) {
            $category = Category::where('name', $categoryName)->first();
            foreach ($subs as $sub) {
                Subcategory::create([
                    'name' => $sub,
                    'category_id' => $category->id
                ]);
            }
        }
    }
}

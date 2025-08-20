<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subcategories')->insert([
            // Printing
            ['category_id' => 1, 'name' => 'Printer'],
            ['category_id' => 1, 'name' => 'Paper'],
            ['category_id' => 1, 'name' => 'Cartridge'],

            // Monitoring
            ['category_id' => 2, 'name' => 'CCTV'],
            ['category_id' => 2, 'name' => 'Coaxial'],

            // Networking
            ['category_id' => 3, 'name' => 'Router'],
            ['category_id' => 3, 'name' => 'Switch'],
            ['category_id' => 3, 'name' => 'AP'],
            ['category_id' => 3, 'name' => 'LAN'],

            // Workstation
            ['category_id' => 4, 'name' => 'Monitor'],
            ['category_id' => 4, 'name' => 'Keyboard'],
            ['category_id' => 4, 'name' => 'Mouse'],
            ['category_id' => 4, 'name' => 'PC'],
        ]);
    }
}

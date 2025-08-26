<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Subcategory;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['name' => 'EPSON L3110', 'subcategory' => 'Printer'],
            ['name' => 'HP LaserJet 1020', 'subcategory' => 'Printer'],
            ['name' => 'TP-Link AX3000', 'subcategory' => 'Router'],
            ['name' => 'Ruijie Reyee EG105W', 'subcategory' => 'AP'],
            ['name' => 'Camtrix V380 Pro', 'subcategory' => 'CCTV'],
        ];

        foreach ($items as $item) {
            $subcategory = Subcategory::where('name', $item['subcategory'])->first();
            Item::create([
                'name' => $item['name'],
                'subcategory_id' => $subcategory->id,
                'date_of_arrival' => now()
            ]);
        }
    }
}

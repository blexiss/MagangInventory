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
            ['name' => 'EPSON L3110', 'subcategory' => 'Printer', 'quantity' => 20, 'unique_attribute' => 'Model L3110'],
            ['name' => 'HP LaserJet 1020', 'subcategory' => 'Printer', 'quantity' => 15, 'unique_attribute' => 'Model 1020'],
            ['name' => 'TP-Link AX3000', 'subcategory' => 'Router', 'quantity' => 15, 'unique_attribute' => 'AX3000'],
            ['name' => 'Ruijie Reyee EG105W', 'subcategory' => 'AP', 'quantity' => 15, 'unique_attribute' => 'EG105W'],
            ['name' => 'Camtrix V380 Pro', 'subcategory' => 'CCTV', 'quantity' => 18, 'unique_attribute' => 'V380 Pro'],
        ];

        foreach ($items as $item) {
            $subcategory = Subcategory::where('name', $item['subcategory'])->first();
            Item::create([
                'name' => $item['name'],
                'subcategory_id' => $subcategory->id,
                'quantity' => $item['quantity'],
                'unique_attribute' => $item['unique_attribute'],
                'date_of_arrival' => now()
            ]);
        }
    }
}

<?php

namespace App\Console;

use App\Jobs\CheckCCTVStatus;
use App\Models\Item;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Log;

class Kernel
{
    public function __invoke()
    {
        $cctvSubcategory = Subcategory::where('name', 'CCTV')->first();

        if (!$cctvSubcategory) {
            Log::warning('Subcategory CCTV tidak ditemukan!');
            return;
        }

        $cctvItems = Item::where('subcategory_id', $cctvSubcategory->id)->get();

        foreach ($cctvItems as $item) {
            Log::info("Dispatch job untuk Item ID: {$item->id}");
            CheckCCTVStatus::dispatch($item);
        }

        Log::info('CheckAllCCTV selesai dispatch semua item CCTV');
    }
}

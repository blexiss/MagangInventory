<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class detailItemsCintroller extends Controller
{
    public function show($id)
    {
        $item = Item::with('subcategory.category')->findOrFail($id);
        return view('partials.subpartials.detail_items', compact('item'));
    }
}

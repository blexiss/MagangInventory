<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class InventoryController extends Controller
{
    public function index()
    {
        $perPage = 10;

        // Get items with subcategory for table
        $items = Item::with('subcategory')->paginate($perPage);

        // Get categories with subcategories for modal dropdown
        $categories = Category::with('subcategories')->get();

        return view('inventory', [
            'items' => $items,
            'categories' => $categories,
            'currentPage' => 'inventory', // for navbar highlighting
            'perPage' => $perPage
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subcategory_id' => 'required|exists:subcategories,id',
            'quantity' => 'required|integer|min:0',
        ]);

        Item::create([
            'name' => $request->name,
            'subcategory_id' => $request->subcategory_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('inventory')->with('success', 'Item added successfully!');
    }
}

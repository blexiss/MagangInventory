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

        // ambil items beserta subcategory & category
        $items = Item::with('subcategory.category')->paginate($perPage);

        // kategori & subkategori untuk dropdown modal
        $categories = Category::with('subcategories')->get();

        // mapping agar siap ditampilkan di blade
        $mappedItems = $items->getCollection()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'quantity' => $item->qty, // diambil dari database
                'subcategory' => $item->subcategory->name,
                'subcategory_id' => $item->subcategory_id,
                'category' => $item->subcategory->category->name,
                'status' => $item->status,
            ];
        });

        return view('inventory', [
            'items' => $mappedItems,
            'categories' => $categories,
            'currentPage' => 'inventory',
            'perPage' => $perPage
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        Item::create([
            'name' => $validated['name'],
            'subcategory_id' => $validated['subcategory_id'],
            'json' => [], // default kosong array agar qty = 0
            'date_of_arrival' => now(),
        ]);

        return redirect()->back()->with('success', 'Item added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        $item = Item::findOrFail($id);
        $item->update([
            'name' => $validated['name'],
            'subcategory_id' => $validated['subcategory_id'],
        ]);

        return redirect()->back()->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Item deleted successfully!');
    }
}

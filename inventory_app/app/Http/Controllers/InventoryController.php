<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\AuditLog;

class InventoryController extends Controller
{
    private $dummyUsers = ['Dimas'];

    // Fungsi untuk membuat audit log
    private function createAuditLog($action, $model, $oldData = null, $newData = null)
    {
        $user = $this->dummyUsers[array_rand($this->dummyUsers)];

        // Fungsi mapping agar tidak simpan ID, tapi langsung nama
        $mapData = function ($data) {
            if (!$data) return null;

            // Jika datanya model Item (ada subcategory_id)
            if (isset($data['subcategory_id'])) {
                $subcategory = Subcategory::with('category')->find($data['subcategory_id']);
                return [
                    'name'        => $data['name'] ?? null,
                    'subcategory' => $subcategory ? $subcategory->name : null,
                    'category'    => $subcategory && $subcategory->category ? $subcategory->category->name : null,
                ];
            }

            return $data;
        };

        AuditLog::create([
            'user'     => $user,
            'action'   => $action,
            'model'    => $model,
            'old_data' => $oldData ? json_encode($mapData($oldData)) : null,
            'new_data' => $newData ? json_encode($mapData($newData->toArray())) : null,
        ]);
    }

    // Tampilkan inventory + audit log
    public function index()
    {
        $perPage = 10;

        // Ambil items beserta subcategory & category
        $items = Item::with('subcategory.category')->paginate($perPage);
        $categories = Category::with('subcategories')->get();

        // Mapping data item
        $mappedItems = $items->getCollection()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'quantity' => $item->qty ?? 0,
                'subcategory' => $item->subcategory->name,
                'subcategory_id' => $item->subcategory_id,
                'category' => $item->subcategory->category->name,
                'status' => $item->status,
            ];
        });

        // Ambil 10 audit log terbaru
        $logs = AuditLog::latest()->take(10)->get();

        return view('inventory', [
            'items' => $mappedItems,
            'categories' => $categories,
            'logs' => $logs,
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

        $item = Item::create([
            'name' => $validated['name'],
            'subcategory_id' => $validated['subcategory_id'],
            'json' => [],
            'date_of_arrival' => now(),
        ]);

        $this->createAuditLog('add', 'Item', null, $item);

        return redirect()->back()->with('success', 'Item added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        $item = Item::findOrFail($id);
        $oldData = $item->toArray();

        $item->update([
            'name' => $validated['name'],
            'subcategory_id' => $validated['subcategory_id'],
        ]);

        $this->createAuditLog('edit', 'Item', $oldData, $item);

        return redirect()->back()->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $oldData = $item->toArray();
        $item->delete();

        $this->createAuditLog('delete', 'Item', $oldData, null);

        return redirect()->back()->with('success', 'Item deleted successfully!');
    }
}

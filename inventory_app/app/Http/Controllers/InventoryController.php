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

        // Mapping agar tidak simpan ID tapi langsung nama
        $mapData = function ($data) {
            if (!$data) return null;

            if (isset($data['subcategory_id'])) {
                $subcategory = Subcategory::with('category')->find($data['subcategory_id']);
                return [
                    'name'        => $data['name'] ?? null,
                    'subcategory' => $subcategory ? $subcategory->name : null,
                    'category'    => $subcategory && $subcategory->category ? $subcategory->category->name : null,
                    'quantity'    => $data['quantity'] ?? 0,
                ];
            }

            return $data;
        };

        AuditLog::create([
            'user'     => $user,
            'action'   => $action,
            'model'    => $model,
            'old_data' => $oldData ? json_encode($mapData($oldData)) : null,
            'new_data' => $newData ? json_encode($mapData(is_array($newData) ? $newData : $newData->toArray())) : null,
        ]);
    }

    // Tampilkan inventory + audit log
    public function index()
    {
        $perPage = 10;

        $items = Item::with('subcategory.category')->paginate($perPage);
        $categories = Category::with('subcategories')->get();

        $mappedItems = $items->getCollection()->map(function ($item) {
            return [
                'id'          => $item->id,
                'name'        => $item->name,
                'quantity'    => $item->quantity ?? 0, // konsisten pakai "quantity"
                'subcategory' => $item->subcategory->name,
                'subcategory_id' => $item->subcategory_id,
                'category'    => $item->subcategory->category->name,
                'status'      => $item->status,
            ];
        });

        $logs = AuditLog::latest()->take(10)->get();

        return view('inventory', [
            'items'       => $mappedItems,
            'categories'  => $categories,
            'logs'        => $logs,
            'currentPage' => 'inventory',
            'perPage'     => $perPage
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        $item = Item::create([
            'name'           => $validated['name'],
            'subcategory_id' => $validated['subcategory_id'],
            'quantity'       => 0,
            'date_of_arrival'=> now(),
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
            'name'           => $validated['name'],
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

    // Update quantity (in / out)
    public function updateQuantity(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
            'action' => 'required|in:in,out',
        ]);

        $item = Item::findOrFail($id);
        $oldData = $item->toArray();

        $amount = $validated['amount'];

        if ($validated['action'] === 'in') {
            $item->quantity += $amount;
        } else {
            $item->quantity = max(0, $item->quantity - $amount);
        }

        $item->save();

        $this->createAuditLog($validated['action'], 'Item', $oldData, $item);

        return redirect()->route('inventory.detailitems', $id)->with('success', 'Quantity updated successfully.');
    }
}

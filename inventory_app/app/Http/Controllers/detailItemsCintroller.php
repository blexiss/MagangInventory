<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use App\Models\Subcategory;

class detailItemsCintroller extends Controller
{
    // Dummy user
    private $dummyUsers = ['Dimas'];

    /**
     * Fungsi untuk membuat audit log
     */
    private function createAuditLog($action, $model, $oldData = null, $newData = null)
    {
        $user = $this->dummyUsers[array_rand($this->dummyUsers)];

        $mapData = function ($data) {
            if (!$data) return null;

            if (isset($data['subcategory_id'])) {
                $subcategory = Subcategory::with('category')->find($data['subcategory_id']);
                return [
                    'name'        => $data['name'] ?? null,
                    'subcategory' => $subcategory ? $subcategory->name : null,
                    'category'    => $subcategory && $subcategory->category ? $subcategory->category->name : null,
                    'quantity'    => $data['quantity'] ?? 0,
                    'use'         => $data['use'] ?? 0,
                    'damaged'     => $data['damaged'] ?? 0,
                    'json'        => $data['json'] ?? [],
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

    /**
     * Tampilkan detail item
     */
    public function show($id)
    {
        $item = Item::with('subcategory')->findOrFail($id);
        return view('partials.subpartials.detail_items', compact('item'));
    }

    /**
     * Proses penggunaan item
     */
    public function processUse(Request $request, Item $item)
    {
        $oldData = $item->toArray();
        $amount = (int) $request->input('amount', 1);

        $entry = [
            'used_at' => now()->format('Y-m-d H:i:s'),
        ];

        foreach ($request->except(['_token', 'amount']) as $key => $value) {
            $entry[$key] = $value;
        }

        $json = $item->json ?? [];
        $json[] = $entry;

        $item->json = $json;
        $item->use  = ($item->use ?? 0) + $amount;
        $item->save();

        $this->createAuditLog('use', 'Item', $oldData, $item);

        return redirect()->route('inventory.detailitems', $item->id)
            ->with('success', 'Item used successfully!');
    }

    /**
     * Update JSON item (delete, return, damaged, update)
     */
    public function updateJson(Request $request, Item $item)
    {
        $oldData = $item->toArray();
        $action = $request->input('action');
        $json   = $item->json ?? [];

        // Ambil reason yang dikirim dari modal
        $reason = $request->input('reason', 'No reason provided');

        // DELETE action
        if ($action === 'delete') {
            foreach ($request->input('delete', []) as $index => $val) {
                if (isset($json[$index])) {
                    $item->use -= 1;
                    unset($json[$index]);
                }
            }
            $json = array_values($json);
            if ($item->use < 0) $item->use = 0;
        }

        // RETURN action
        if ($action === 'return') {
            foreach ($request->input('delete', []) as $index => $val) {
                if (isset($json[$index])) {
                    $item->use = max(($item->use ?? 0) - 1, 0);
                    $json[$index]['return_reason'] = $reason; // simpan alasan
                    unset($json[$index]);
                }
            }
            $json = array_values($json);
        }

        // DAMAGED action
        if ($action === 'damaged') {
            foreach ($request->input('delete', []) as $index => $val) {
                if (isset($json[$index])) {
                    $item->use = max(($item->use ?? 0) - 1, 0);
                    $item->damaged = ($item->damaged ?? 0) + 1;
                    $json[$index]['damaged_reason'] = $reason; // simpan alasan
                    unset($json[$index]);
                }
            }
            $json = array_values($json);
        }

        // UPDATE action
        if ($action === 'update' && $request->has('json')) {
            foreach ($request->input('json') as $index => $data) {
                $json[$index] = $data;
            }
        }

        $item->json = $json;
        $item->save();

        // Simpan audit log termasuk reason
        $this->createAuditLog($action, 'Item', $oldData, $item);

        return back()->with('success', 'Data updated successfully!');
    }
}

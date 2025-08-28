<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class detailItemsCintroller extends Controller
{
    public function show($id)
    {
        $item = Item::with('subcategory')->findOrFail($id);
        return view('partials.subpartials.detail_items', compact('item'));
    }

    public function processUse(Request $request, Item $item)
    {
        // Validasi: hanya required, tanpa integer/min/max
        $validated = $request->validate([
            'amount' => 'required',
        ]);

        $amount = $validated['amount']; // biarkan apa adanya

        // Optional: cek kalau ingin stok cukup (bisa tetap pakai integer cast)
        if ((float)$item->quantity < (float)$amount) {
            return back()->with('error', 'Not enough stock available!');
        }
        
        // Ambil json lama
        $json = $item->json ?? [];

        // Entry baru
        $entry = [
            'amount'  => $amount,
            'used_at' => now()->format('Y-m-d H:i:s'),
        ];

        // Field tambahan dari form
        foreach ($request->except(['_token', 'amount']) as $key => $value) {
            $entry[$key] = $value;
        }

        // Tambahkan entry
        $json[] = $entry;
        $item->json = $json;

        $item->save();

        return redirect()
            ->route('inventory.detailitems', $item->id)
            ->with('success', 'Item used successfully!');
    }

    public function updateJson(Request $request, Item $item)
    {
        $action = $request->input('action');
        $json   = $item->json ?? [];

        if ($action === 'delete') {
            foreach ($request->input('delete', []) as $index => $val) {
                unset($json[$index]);
            }
            $json = array_values($json);
        }

        if ($action === 'update' && $request->has('json')) {
            foreach ($request->input('json') as $index => $data) {
                $json[$index] = $data;
            }
        }

        $item->json = $json;
        $item->save();

        return back()->with('success', 'Data updated successfully!');
    }
}

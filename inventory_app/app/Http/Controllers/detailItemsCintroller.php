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
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $amount = (float)$validated['amount'];

        if ($item->quantity < $amount) {
            return back()->with('error', 'Not enough stock available!');
        }

        $entry = [
            'amount'  => $amount,
            'used_at' => now()->format('Y-m-d H:i:s'),
        ];

        foreach ($request->except(['_token', 'amount']) as $key => $value) {
            $entry[$key] = $value;
        }

        $json = $item->json ?? [];
        $json[] = $entry;

        $item->json     = $json;
        $item->quantity -= $amount;
        $item->use      = ($item->use ?? 0) + $amount;
        $item->save();

        return redirect()->route('inventory.detailitems', $item->id)
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

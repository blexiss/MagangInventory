<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class DetailItemsController extends Controller
{
    // Tampilkan detail item
    public function show($id)
    {
        $item = Item::with('subcategory')->findOrFail($id);
        return view('partials.subpartials.detail_items', compact('item'));
    }

    // Tampilkan form Use Item
    public function showUseForm(Item $item)
    {
        $fieldsByCategory = [
            'Printer'   => ['Connectivity (USB/WiFi)'],
            'Paper'     => ['Size'],
            'Cartridge' => ['Color'],
            'CCTV'      => ['Camera Type', 'Resolution', 'IP Address', 'Stream URL'],
            'Coaxial'   => ['Length (Meter)'],
            'Router'    => ['IP Address', 'WiFi Standard'],
            'Switch'    => ['# of Ports', 'IP Address'],
            'AP'        => ['SSID', 'IP Address', 'Max User'],
            'Monitor'   => ['Screen Size', 'Resolution'],
            'PC'        => ['CPU', 'RAM', 'HDD/SSD Size'],
            'Mouse'     => ['Connectivity'],
        ];

        $category = $item->subcategory->name ?? 'Unknown';
        $fields   = $fieldsByCategory[$category] ?? [];

        return view('partials.subpartials.detail_items_use', compact('item', 'fields'));
    }

    // Proses Use Item
    public function processUse(Request $request, Item $item)
    {
        $request->validate([
            'amount' => 'required|integer|min:1|max:' . $item->quantity,
        ]);

        $amount = (int) $request->input('amount', 1);
        $data   = collect($request->except(['_token', 'amount']))->toArray();

        $json = $item->json ?? [];
        for ($i = 0; $i < $amount; $i++) {
            $json[] = $data;
        }
        $item->json     = $json;
        $item->quantity = max(0, $item->quantity - $amount);
        $item->save();

        return redirect()->route('inventory')->with('success', 'Item used successfully!');
    }

    // Update/Delete JSON
    public function updateJson(Request $request, Item $item)
    {
        $action = $request->input('action');
        $json   = $item->json ?? [];

        if ($action === 'update') {
            foreach ($request->input('json', []) as $index => $data) {
                if (isset($json[$index])) {
                    $json[$index] = (array) $data;
                }
            }
            $message = 'JSON entry updated successfully!';
        } elseif ($action === 'delete') {
            foreach ($request->input('delete', []) as $index => $value) {
                if (isset($json[$index])) {
                    unset($json[$index]);
                }
            }
            $json = array_values($json); // reindex
            $message = 'Selected entries deleted successfully!';
        } else {
            return redirect()->back()->with('error', 'Invalid action!');
        }

        $item->json = $json;
        $item->save();

        return redirect()->back()->with('success', $message);
    }
}

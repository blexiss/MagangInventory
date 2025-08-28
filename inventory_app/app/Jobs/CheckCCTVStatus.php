<?php

namespace App\Jobs;

use App\Models\Item;
use App\Models\Subcategory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckCCTVStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function handle()
    {
        $cctvSubcategory = Subcategory::where('name', 'CCTV')->first();
        if (!$cctvSubcategory) {
            Log::warning('Subcategory CCTV tidak ditemukan!');
            return;
        }

        // hanya untuk item CCTV
        if ($this->item->subcategory_id !== $cctvSubcategory->id) {
            Log::info("Item ID {$this->item->id} bukan CCTV, dilewati.");
            return;
        }

        $jsonData = $this->item->json ?? [];
        $results = [];

        foreach ($jsonData as $cctv) {
            $ip = $cctv['ip_address'] ?? null;
            if (!$ip) continue;

            $online = $this->pingWindows($ip);
            $results[] = [
                'ip_address' => $ip,
                'status' => $online ? 'ONLINE' : 'OFFLINE',
                'checked_at' => now(),
            ];

            Log::info("CCTV IP {$ip} -> " . ($online ? 'ONLINE' : 'OFFLINE'));
        }

        $this->item->check = json_encode($results);
        $this->item->save();

        Log::info("✔ Selesai cek CCTV untuk Item ID: {$this->item->id}");
    }

    private function pingWindows($ip)
    {
        $command = sprintf('ping -n 1 -w 1000 %s', escapeshellarg($ip));
        $outputText = shell_exec($command);
        Log::debug("Ping Output [{$ip}]: " . $outputText);
        return stripos($outputText, 'TTL') !== false;
    }
}

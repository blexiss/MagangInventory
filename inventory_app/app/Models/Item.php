<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'subcategory_id',
        'json',
        'date_of_arrival',
        'quantity', // quantity di database
    ];

    protected $casts = [
        'json' => 'array', // decode otomatis json
    ];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    // Quantity dikurangi jumlah item di JSON
    public function getQtyAttribute()
    {
        $baseQty = $this->attributes['quantity'] ?? 0;
        $usedQty = is_array($this->json) ? count($this->json) : 0;

        $remainingQty = $baseQty - $usedQty;
        return $remainingQty >= 0 ? $remainingQty : 0; // jangan negatif
    }

    // Status otomatis dari quantity
    public function getStatusAttribute()
    {
        $qty = $this->qty;
        if ($qty <= 5) return "Low";
        if ($qty <= 10) return "In Stock";
        return "High";
    }
}

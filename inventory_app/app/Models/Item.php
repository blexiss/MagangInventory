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
        'quantity',
        'damaged',
        'use',
    ];

    /**
     * Pastikan json selalu array.
     * Gunakan accessor saja, casting 'array' dihapus agar tidak bentrok.
     */
    public function getJsonAttribute($value)
    {
        if (is_null($value)) {
            return []; // default []
        }

        return is_array($value) ? $value : json_decode($value, true);
    }

    // Relasi subcategory
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    // Sisa quantity langsung dari kolom database
    public function getQtyAttribute()
    {
        $quantity = $this->attributes['quantity'] ?? 0;
        $used = $this->attributes['use'] ?? 0;
        $damaged = $this->attributes['damaged'] ?? 0;

        $remaining = $quantity - $used - $damaged;

        return $remaining > 0 ? $remaining : 0; // jangan negatif
    }

    // Status otomatis
    public function getStatusAttribute()
    {
        $qty = $this->qty; // otomatis sudah quantity - use - damaged

        if ($qty <= 0) {
            return "Out of Stock";
        }

        if ($qty <= 20) {
            return "Low";
        }

        return "In Stock";
    }
}

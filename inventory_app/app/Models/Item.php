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
        return $this->attributes['quantity'] ?? 0;
    }

    // Status otomatis
    public function getStatusAttribute()
    {
        $qty = $this->qty;

        if ($qty <= 0) {
            return "Out of Stock";
        }

        if ($qty <= 10) {
            return "Low";
        }

        return "In Stock";
    }
}

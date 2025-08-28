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

    public function getJsonAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    protected $casts = [
        'json' => 'array',
    ];

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
        if ($qty <= 0) return "Out of Stock";
        if ($qty <= 10) return "Low";
        return "In Stock";
    }
}

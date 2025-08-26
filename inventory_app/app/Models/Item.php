<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'subcategory_id',
        'json',
        'date_of_arrival'
    ];

    protected $casts = [
        'json' => 'array', // otomatis decode ke array
    ];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    // qty otomatis dihitung dari JSON
    public function getQtyAttribute()
    {
        return is_array($this->json) ? count($this->json) : 0;
    }

    // status otomatis dari qty
    public function getStatusAttribute()
    {
        $qty = $this->qty;
        if ($qty <= 5) return "Low";
        if ($qty <= 10) return "In Stock";
        return "High";
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subcategory_id',
        'quantity',
        'date_of_arrival',
        'unique_attribute'
    ];

    // Item belongs to a Subcategory
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    // Item has many Assignments
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // Helper function: count assigned items
    public function assignedCount()
    {
        return $this->assignments()->whereNull('returned_at')->count();
    }

    // Helper function: count in-stock items
    public function inStockCount()
    {
        return $this->quantity - $this->assignedCount();
    }
}

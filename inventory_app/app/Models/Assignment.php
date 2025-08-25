<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'location',
        'assigned_at',
        'returned_at'
    ];

    // Assignment belongs to an Item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}

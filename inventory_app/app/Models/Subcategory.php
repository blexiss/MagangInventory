<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];

    // Subcategory belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Subcategory has many Items
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}

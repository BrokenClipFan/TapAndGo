<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'image_path',
        'status'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}

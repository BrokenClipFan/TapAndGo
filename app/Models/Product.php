<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'image_path',
        'status',
        'visible'
    ];

    protected static function booted(): void {
        static::addGlobalScope('visible', function(Builder $builder) {
            $builder->where('visible', true);
        });
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Product;

class Category extends Model
{
    protected $fillable = [
        'name',
        'image_path',
        'visible',
    ];

    protected static function booted(): void {
        static::addGlobalScope('visible', function(Builder $builder) {
            $builder->where('visible', true);
        });
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}

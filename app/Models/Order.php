<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Order extends Model
{
    protected $fillable = [
        'total_price',
        'order_code',
        'status',
    ];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}

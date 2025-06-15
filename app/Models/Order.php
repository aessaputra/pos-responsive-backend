<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'transaction_number',
        'total_price',
        'total_item',
        'cashier_id',
        'payment_method',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'gema_orders';

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'payment_method',
        'shipping_address',
        'payment_proof',
    ];


    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

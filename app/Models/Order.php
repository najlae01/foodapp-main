<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'orderDate',
        'orderAmount',
        'orderStatus'
    ];

    public function payment()
    {
        return $this->hasOne('App\Models\Payment', 'payment_id');
    }

    public function carrier()
    {
        return $this->hasOne('App\Models\Carrier', 'carrier_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'user_id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}

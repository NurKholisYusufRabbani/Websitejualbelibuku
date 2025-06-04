<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingStatus extends Model
{
    use HasFactory;

    // 👇 Tambahkan baris ini:
    protected $table = 'shipping_status';

    protected $fillable = [
        'order_id',
        'status',
        'tracking_number',
    ];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

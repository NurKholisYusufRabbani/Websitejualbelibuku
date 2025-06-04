<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discounts';

    protected $fillable = [
        'kode',
        'persentase',
        'minimal_pembelian',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_discounts');
    }

    public function applyDiscount($amount)
    {
        if ($amount < $this->minimal_pembelian) {
            return false; // berarti gak bisa pakai diskon
        }
        return $amount - ($amount * ($this->persentase / 100));
    }
}

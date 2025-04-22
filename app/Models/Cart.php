<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'cart';
    protected $fillable = ['user_id', 'book_id', 'jumlah', 'harga'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

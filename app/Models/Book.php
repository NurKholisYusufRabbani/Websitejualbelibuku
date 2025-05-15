<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Daftar atribut yang bisa diisi secara massal
    protected $fillable = [
        'judul', 
        'penulis', 
        'harga', 
        'kategori_id', 
        'stok', 
        'deskripsi', 
        'cover_image',
    ];

    // Menonaktifkan timestamps (created_at dan updated_at)
    public $timestamps = false;

    /**
     * Relasi ke model Category (Satu kategori untuk banyak buku).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlist')->withTimestamps();
    }
}

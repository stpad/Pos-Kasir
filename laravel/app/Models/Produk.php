<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori_id',
        'harga_beli',
        'harga_jual',
        'stok_awal',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function isLowStock(): bool
    {
        return $this->stok_awal <= 5;
    }
}

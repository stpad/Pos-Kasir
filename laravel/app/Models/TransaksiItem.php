<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'jumlah',
        'harga_saat_transaksi',
        'subtotal',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_saat_transaksi' => 'integer',
        'subtotal' => 'integer',
    ];

    /**
     * Get the transaksi that owns the item.
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }

    /**
     * Get the produk that owns the item.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
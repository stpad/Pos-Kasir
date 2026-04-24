<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode_transaksi',
        'total_harga',
        'jumlah_bayar',
        'kembalian',
        'status',
    ];

    protected $casts = [
        'total_harga' => 'integer',
        'jumlah_bayar' => 'integer',
        'kembalian' => 'integer',
    ];

    /**
     * Get the user that owns the transaksi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the items for the transaksi.
     */
    public function items(): HasMany
    {
        return $this->hasMany(TransaksiItem::class);
    }

    /**
     * Generate unique kode transaksi.
     */
    public static function generateKode(): string
    {
        $date = now()->format('Ymd');
        $lastTransaksi = self::whereDate('created_at', today())->latest()->first();
        $sequence = $lastTransaksi ? (int)substr($lastTransaksi->kode_transaksi, -4) + 1 : 1;
        return 'TRX-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_penjualan',
        'id_produk',
        'jumlah',
        'harga_beli_saat_ini',
        'harga_jual_saat_ini',
        'subtotal',
    ];

    protected $casts = [
        'harga_beli_saat_ini' => 'decimal:2',
        'harga_jual_saat_ini' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id_penjualan');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }
}

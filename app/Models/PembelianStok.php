<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembelianStok extends Model
{
    use HasFactory;

    protected $table = 'pembelian_stok';
    protected $primaryKey = 'id_pembelian';

    protected $fillable = [
        'id_produk',
        'tanggal_masuk',
        'jumlah_barang_masuk',
        'harga_beli_satuan',
        'total_harga_beli',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'jumlah_barang_masuk' => 'integer',
        'harga_beli_satuan' => 'decimal:2',
        'total_harga_beli' => 'decimal:2',
    ];

    /**
     * Relasi ke tabel product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenyesuaianStok extends Model
{
    use HasFactory;

    protected $table = 'penyesuaian_stok';
    protected $primaryKey = 'id_penyesuaian';

    protected $fillable = [
        'id_produk',
        'tanggal_cek',
        'jumlah_selisih',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_cek' => 'date',
        'jumlah_selisih' => 'integer',
    ];

    /**
     * Relasi ke tabel product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }
}

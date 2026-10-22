<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_kategori',
        'kode_produk',
        'nama_produk',
        'satuan_terkecil',
        'satuan_besar',
        'isi_per_satuan_besar',
        'lokasi_produk',
        'stok_minimum',
        'stok_produk',
        'harga_jual',
        'harga_beli_terakhir',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }

    public function pembelianStok(): HasMany
    {
        return $this->hasMany(PembelianStok::class, 'id_produk', 'id_produk');
    }

    public function penyesuaianStok(): HasMany
    {
        return $this->hasMany(PenyesuaianStok::class, 'id_produk', 'id_produk');
    }
}

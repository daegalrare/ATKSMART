<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';

    protected $fillable = [
        'id_akun',
        'no_invoice',
        'tanggal_penjualan',
        'total_bayar',
        'uang_diterima',
        'kembalian',
    ];

    protected $casts = [
        'tanggal_penjualan' => 'datetime',
        'total_bayar' => 'decimal:2',
        'uang_diterima' => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'id_akun', 'id_akun');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan', 'id_penjualan');
    }
}

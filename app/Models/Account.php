<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'account';

    protected $primaryKey = 'id_akun';

    protected $fillable = [
        'email_akun',
        'nama_akun',
        'no_telepon',
        'role',
        'password_hashed',
    ];
}
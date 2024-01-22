<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_barang',
        'nama_barang',
        'merk',
        'harga',
        'created_at',
        'updated_at',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersediaanBarang extends Model
{
    use HasFactory;
    protected $table = 'persediaan_barang';
    protected $fillable = ['barang_id', 'stok', 'stok_min', 'stok_max'];
}

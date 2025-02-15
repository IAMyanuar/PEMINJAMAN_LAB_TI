<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanBahan extends Model
{
    use HasFactory;
    protected $fillable= ['jumlah'];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'id_bahan');
    }

    public function peminjamanAlatDanBahan()
    {
        return $this->belongsTo(PeminjamanAlatDanBahan::class, 'id_peminjaman_alat_bahan');
    }
}

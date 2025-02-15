<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanAlat extends Model
{
    use HasFactory;
    protected $fillable= ['jumlah'];

   public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }

    public function peminjamanAlatDanBahan()
    {
        return $this->belongsTo(PeminjamanAlatDanBahan::class, 'id_peminjaman_alat_bahan');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanAlatDanBahan extends Model
{
    use HasFactory;
    protected $table = 'peminjaman_alat_dan_bahans';
    protected $fillable = ['kelas', 'tgl_pinjam', 'tgl_selesai','pic', 'status','jumlah_alat','jumlah_bahan'];
    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function peminjamanalat()
    {
        return $this->hasMany(PeminjamanAlat::class, 'id_peminjaman_alat_bahan');
    }

    public function peminjamanbahan()
    {
        return $this->hasMany(PeminjamanBahan::class, 'id_peminjaman_alat_bahan');
    }

}

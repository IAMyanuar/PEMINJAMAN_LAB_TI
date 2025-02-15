<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;
    protected $table = 'bahans';
    protected $fillable=['nama','satuan','jumlah'];

    public function peminjamanAlatDanBahan()
    {
        return $this->hasMany(PeminjamanAlatDanBahan::class, 'id_bahan');
    }
}

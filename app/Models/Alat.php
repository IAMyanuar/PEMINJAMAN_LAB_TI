<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;
    protected $table = 'alats';
    protected $fillable=['nama','satuan','foto','jumlah'];

    public function peminjamanAlatDanBahan()
    {
        return $this->hasMany(PeminjamanAlatDanBahan::class, 'id_alat');
    }
}

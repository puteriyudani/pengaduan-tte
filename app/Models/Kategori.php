<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategori'; // nama tabel

    protected $fillable = [
        'nama_kategori',
    ];

    /**
     * Relasi ke pengaduan
     */
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'kategori_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPD extends Model
{
    use HasFactory;

    protected $table = 'opds'; // nama tabel

    protected $fillable = [
        'nama_opd',
    ];

    /**
     * Relasi ke pengaduan
     */
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'opd_id');
    }
}

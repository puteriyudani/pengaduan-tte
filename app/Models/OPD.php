<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OPD extends Model
{
    use HasFactory, SoftDeletes;

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

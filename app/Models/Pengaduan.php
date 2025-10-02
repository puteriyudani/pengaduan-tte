<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';
    protected $guarded = [];

    protected $fillable = [
        'nama',
        'email',
        'whatsapp',
        'kategori_id',
        'opd',
        'keterangan',
        'tanggal',
        'hari',
    ];

    /**
     * Relasi ke tabel kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}

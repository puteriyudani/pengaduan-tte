<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengaduan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengaduan';

    protected $fillable = [
        'nama',
        'email',
        'whatsapp',
        'kategori_id',
        'opd_id',
        'keterangan',
        'tanggal',
        'tanggal_selesai',
        'hari',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class)->withTrashed();
    }

    public function opd()
    {
        return $this->belongsTo(OPD::class)->withTrashed();
    }
}

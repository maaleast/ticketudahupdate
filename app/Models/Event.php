<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'tanggal_waktu',
        'lokasi',
        'lokasi_id',
        'kategori_id',
        'gambar',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
    ];

    protected $appends = ['lokasi_name'];

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    /**
     * Get the lokasi name safely
     */
    public function getLokasiNameAttribute()
    {
        if ($this->lokasi_id) {
            return Lokasi::find($this->lokasi_id)?->nama_lokasi;
        }
        return null;
    }
}

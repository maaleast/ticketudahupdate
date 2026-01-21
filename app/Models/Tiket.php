<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'tipe_tiket_id',
        'harga',
        'stok',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function tipeTiket()
    {
        return $this->belongsTo(TipeTiket::class, 'tipe_tiket_id');
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'detail_orders')
            ->withPivot('jumlah', 'subtotal_harga');
    }
}

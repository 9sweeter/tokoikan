<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'alamat',
        'bukti_pembayaran',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper method for status badge
    public function getStatusBadge()
    {
        $badges = [
            'pending' => '<span style="background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 20px; font-size: 14px;">⏳ Pending</span>',
            'accepted' => '<span style="background: #d1e7dd; color: #0f5132; padding: 6px 12px; border-radius: 20px; font-size: 14px;">✅ Diterima</span>',
            'cancelled' => '<span style="background: #f8d7da; color: #842029; padding: 6px 12px; border-radius: 20px; font-size: 14px;">❌ Dibatalkan</span>',
        ];

        return $badges[$this->status] ?? '';
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'appointment_id',
        'amount',
        'payment_method',
        'payment_status',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format((float)$this->amount, 0, ',', '.');
    }

    public function getPaymentStatusBadgeAttribute()
    {
        $badges = [
            'pending' => ['bg-warning', 'Menunggu'],
            'settlement' => ['bg-success', 'Berhasil'],
            'failed' => ['bg-danger', 'Gagal'],
            'refund' => ['bg-info', 'Refund'],
        ];
        return $badges[$this->payment_status] ?? ['bg-secondary', $this->payment_status];
    }
}

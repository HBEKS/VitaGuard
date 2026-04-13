<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'member_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'consultation_fee',
        'status',
        'member_complaint',
        'doctor_notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Helpers
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => ['bg-warning', 'Menunggu'],
            'confirmed' => ['bg-info', 'Dikonfirmasi'],
            'completed' => ['bg-success', 'Selesai'],
            'cancelled' => ['bg-danger', 'Dibatalkan'],
        ];
        return $badges[$this->status] ?? ['bg-secondary', $this->status];
    }
}

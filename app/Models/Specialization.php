<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function doctorProfiles()
    {
        return $this->hasMany(DoctorProfile::class);
    }

    public function doctors()
    {
        return $this->hasManyThrough(User::class, DoctorProfile::class, 'specialization_id', 'id', 'id', 'user_id');
    }
}

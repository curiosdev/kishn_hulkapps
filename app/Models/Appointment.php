<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'date',
        'time',
        'status'
    ];


    
    public function getPatient()
    {
        return $this->hasMany(User::class,'id','user_id');
    }

    public function getDoctor()
    {
        return $this->hasMany(User::class,'id','doctor_id');
    }
}

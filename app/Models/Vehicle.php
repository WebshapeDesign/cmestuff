<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'starting_mileage',
        'make',
        'model',
        'current_mileage',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

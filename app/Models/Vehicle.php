<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration',
        'make',
        'model',
        'year',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vanLogs()
    {
        return $this->hasMany(VanLog::class);
    }

    public function mileageLogs()
    {
        return $this->hasMany(MileageLog::class);
    }
}

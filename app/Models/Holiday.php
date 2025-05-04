<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'type',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $appends = [
        'duration',
        'status_color',
        'type_color',
    ];

    public function getDurationAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'approved' => 'green',
            'pending' => 'yellow',
            'rejected' => 'red',
            default => 'gray',
        };
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'annual' => 'blue',
            'sick' => 'red',
            'unpaid' => 'gray',
            'other' => 'purple',
            default => 'gray',
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
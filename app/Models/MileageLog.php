<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MileageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'vehicle_id',
        'user_id',
        'start_mileage',
        'end_mileage',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'start_mileage' => 'integer',
        'end_mileage' => 'integer',
    ];

    protected $appends = [
        'total_mileage',
        'status_color',
    ];

    public function getTotalMileageAttribute()
    {
        return $this->end_mileage - $this->start_mileage;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'completed' => 'green',
            'pending' => 'yellow',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    // Relationships
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

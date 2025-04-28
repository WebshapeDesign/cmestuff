<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'vehicle_mileage',
        'oil_level_action',
        'oil_level_signed',
        'water_level_action',
        'water_level_signed',
        'tyres_action',
        'tyres_signed',
        'screen_action',
        'screen_signed',
        'vehicle_defects',
        'van_items_check',
        'ppe_check',
    ];

    protected $casts = [
        'van_items_check' => 'array',
        'ppe_check' => 'array',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

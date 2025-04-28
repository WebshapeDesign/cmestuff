<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'week_commencing',
        'entries',
        'materials',
        'others',
        'total_expenses',
    ];

    protected $casts = [
        'week_commencing' => 'date',
        'entries' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

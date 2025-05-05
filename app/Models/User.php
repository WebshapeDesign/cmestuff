<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar_url',
        'mobile_number',
        'department',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        'admin_status',
        'role_color',
    ];

    /**
     * Get the user's initials.
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the is_admin attribute.
     */
    protected function adminStatus(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->isAdmin(),
        );
    }

    /**
     * Relationship: User has many Vehicles.
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * Relationship: User has many Timesheets.
     */
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    /**
     * Relationship: User has many Holiday Requests (if you make a Holiday model later).
     */
    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }

    public function mileageLogs()
    {
        return $this->hasMany(MileageLog::class);
    }

    public function getAdminStatusAttribute()
    {
        return $this->role === 'admin';
    }

    public function getRoleColorAttribute()
    {
        return match($this->role) {
            'admin' => 'purple',
            'manager' => 'blue',
            'driver' => 'green',
            default => 'gray',
        };
    }
}

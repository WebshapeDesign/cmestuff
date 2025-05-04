<?php

namespace App\Policies;

use App\Models\HolidayRequest;
use App\Models\User;

class HolidayRequestPolicy
{
    public function view(User $user, HolidayRequest $holidayRequest)
    {
        return $user->isAdmin() || $user->id === $holidayRequest->user_id;
    }

    public function create(User $user)
    {
        return true; // All authenticated users can create holiday requests
    }

    public function update(User $user, HolidayRequest $holidayRequest)
    {
        return $user->isAdmin() || ($user->id === $holidayRequest->user_id && $holidayRequest->status === 'pending');
    }

    public function delete(User $user, HolidayRequest $holidayRequest)
    {
        return $user->isAdmin() || ($user->id === $holidayRequest->user_id && $holidayRequest->status === 'pending');
    }

    public function approve(User $user, HolidayRequest $holidayRequest)
    {
        return $user->isAdmin() && $holidayRequest->status === 'pending';
    }
} 
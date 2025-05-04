<?php

namespace App\Policies;

use App\Models\MileageLog;
use App\Models\User;

class MileageLogPolicy
{
    public function view(User $user, MileageLog $mileageLog)
    {
        return $user->isAdmin() || $user->id === $mileageLog->user_id;
    }

    public function create(User $user)
    {
        return true; // All authenticated users can create mileage logs
    }

    public function update(User $user, MileageLog $mileageLog)
    {
        return $user->isAdmin() || ($user->id === $mileageLog->user_id && !$mileageLog->is_submitted);
    }

    public function delete(User $user, MileageLog $mileageLog)
    {
        return $user->isAdmin() || ($user->id === $mileageLog->user_id && !$mileageLog->is_submitted);
    }
} 
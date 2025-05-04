<?php

namespace App\Policies;

use App\Models\VanLog;
use App\Models\User;

class VanLogPolicy
{
    public function view(User $user, VanLog $vanLog)
    {
        return $user->isAdmin() || $user->id === $vanLog->user_id;
    }

    public function create(User $user)
    {
        return true; // All authenticated users can create van logs
    }

    public function update(User $user, VanLog $vanLog)
    {
        return $user->isAdmin() || ($user->id === $vanLog->user_id && !$vanLog->is_submitted);
    }

    public function delete(User $user, VanLog $vanLog)
    {
        return $user->isAdmin() || ($user->id === $vanLog->user_id && !$vanLog->is_submitted);
    }
} 
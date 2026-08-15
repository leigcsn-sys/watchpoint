<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Watch;

class WatchPolicy
{
    public function view(User $user, Watch $watch): bool
    {
        return $user->id === $watch->user_id;
    }

    public function delete(User $user, Watch $watch): bool
    {
        return $user->id === $watch->user_id;
    }

    public function update(User $user, Watch $watch): bool
    {
        return $user->id === $watch->user_id;
    }
}
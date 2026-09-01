<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Watch;

class WatchPolicy
{
    public function view(User $user, Watch $watch): bool
    {
        return true;
    }

    public function delete(User $user, Watch $watch): bool
    {
        return true;
    }

    public function update(User $user, Watch $watch): bool
    {
        return true;
    }
}
<?php

namespace App\Policies;

use App\Models\Ending;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EndingPolicy
{
    public function before(User $user) {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
    public function update(User $user, Ending $ending): bool
    {
        return $user->id === $ending->survey->user_id;
    }
    public function delete(User $user, Ending $ending): bool
    {
        return $user->id === $ending->survey->user_id;
    }
}

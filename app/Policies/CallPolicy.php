<?php

namespace App\Policies;

use App\Models\Call;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CallPolicy
{
    public function before(User $user) {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
    public function view(User $user, Call $call): bool
    {
        return $user->id === $call->reserve->survey->user_id;
    }
}

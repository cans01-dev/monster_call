<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function before(User $user) {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }
}

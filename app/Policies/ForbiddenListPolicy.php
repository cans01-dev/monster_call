<?php

namespace App\Policies;

use App\Models\ForbiddenList;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ForbiddenListPolicy
{
    public function before(User $user) {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
    public function view(User $user, ForbiddenList $forbidden_list): bool
    {
        return $user->id === $forbidden_list->survey->user_id;
    }
    public function update(User $user, ForbiddenList $forbidden_list): bool
    {
        return $user->id === $forbidden_list->survey->user_id;
    }
    public function delete(User $user, ForbiddenList $forbidden_list): bool
    {
        return $user->id === $forbidden_list->survey->user_id;
    }
}

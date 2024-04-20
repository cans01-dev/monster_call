<?php

namespace App\Policies;

use App\Models\Option;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OptionPolicy
{
    public function before(User $user) {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
    public function update(User $user, Option $option): bool
    {
        return $user->id === $option->faq->survey->user_id;
    }
    public function delete(User $user, Option $option): bool
    {
        return $user->id === $option->faq->survey->user_id;
    }
}

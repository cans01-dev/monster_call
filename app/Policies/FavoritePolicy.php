<?php

namespace App\Policies;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FavoritePolicy
{
    public function before(User $user) {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
    public function view(User $user, Favorite $favorite): bool
    {
        return $user->id === $favorite->survey->user_id;
    }
    public function update(User $user, Favorite $favorite): bool
    {
        return $user->id === $favorite->survey->user_id;
    }
    public function delete(User $user, Favorite $favorite): bool
    {
        return $user->id === $favorite->survey->user_id;
    }
}

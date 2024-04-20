<?php

namespace App\Policies;

use App\Models\Area;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AreaPolicy
{
    public function before(User $user) {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
    public function view(User $user, Area $area): bool
    {
        if (!$area->survey_id) {
            return true;
        }
        return $user->id === $area->survey->user_id;
    }
    public function update(User $user, Area $area): bool
    {
        return $user->id === $area->survey->user_id;
    }
    public function delete(User $user, Area $area): bool
    {
        return $user->id === $area->survey->user_id;
    }
}

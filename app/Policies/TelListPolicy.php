<?php

namespace App\Policies;

use App\Models\TelList;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TelListPolicy
{
    public function before(User $user) {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
    public function view(User $user, TelList $tel_list): bool
    {
        return $user->id === $tel_list->survey->user_id;
    }
    public function update(User $user, TelList $tel_list): bool
    {
        return $user->id === $tel_list->survey->user_id;
    }
    public function delete(User $user, TelList $tel_list): bool
    {
        return $user->id === $tel_list->survey->user_id;
    }
}

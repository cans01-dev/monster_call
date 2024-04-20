<?php

namespace App\Policies;

use App\Models\Survey;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SurveyPolicy
{
    public function before(User $user) {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
    public function view(User $user, Survey $survey): bool
    {
        return $user->id === $survey->user_id;
    }
    public function update(User $user, Survey $survey): bool
    {
        return $user->id === $survey->user_id;
    }
    public function delete(User $user, Survey $survey): bool
    {
        return $user->id === $survey->user_id;
    }
    public function asset(User $user, Survey $survey): bool
    {
        return $user->id === $survey->user_id;
    }
    public function calls(User $user, Survey $survey): bool
    {
        return $user->id === $survey->user_id;
    }
    public function stats(User $user, Survey $survey): bool
    {
        return $user->id === $survey->user_id;
    }
}

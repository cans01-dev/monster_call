<?php

namespace App\Policies;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FaqPolicy
{
    public function before(User $user) {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
    public function view(User $user, Faq $faq): bool
    {
        return $user->id === $faq->survey->user_id;
    }
    public function update(User $user, Faq $faq): bool
    {
        return $user->id === $faq->survey->user_id;
    }
    public function delete(User $user, Faq $faq): bool
    {
        return $user->id === $faq->survey->user_id;
    }
}

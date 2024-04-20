<?php

namespace App\Policies;

use App\Models\SendEmail;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SendEmailPolicy
{
    public function before(User $user) {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
    public function update(User $user, SendEmail $sendEmail): bool
    {
        return $user->id === $sendEmail->user_id;
    }
    public function delete(User $user, SendEmail $sendEmail): bool
    {
        return $user->id === $sendEmail->user_id;
    }
}

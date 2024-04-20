<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
    public function before(User $user) {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
    public function view(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->survey->user_id;
    }
    public function update(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->survey->user_id;
    }
    public function delete(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->survey->user_id;
    }
}

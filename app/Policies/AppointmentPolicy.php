<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    /**
     * Only the owner of the appointment can cancel it
     */
    public function cancel(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->user_id;
    }

    /**
     * Only the owner of the appointment can complete it
     */
    public function complete(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->user_id;
    }

    /**
     * Only the owner of the appointment can view it
     */
    public function view(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->user_id;
    }
}

<?php

namespace App\Enums;

use App\Traits\EnumArray;

enum AppointmentStatus: string
{
    use EnumArray;

    case Booked = 'booked';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}

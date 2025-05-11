<?php

namespace App\Traits;

trait EnumArray
{
    /**
     * Get an array of names from the cases defined in the enum.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

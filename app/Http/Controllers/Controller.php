<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Healthcare API",
 *     description="RESTful API that handles appointment cancellations using clean architecture principles."
 * ),
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="Authentication and user management"
 * )
 * @OA\Tag(
 *     name="Professionals",
 *     description="Healthcare professionals management"
 * ),
 * @OA\Tag(
 *     name="Appointments",
 *     description="Appointment management and their related operations"
 * ),
 */
abstract class Controller
{
    //
}

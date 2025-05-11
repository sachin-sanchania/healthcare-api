<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointment\BookRequest;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

class AppointmentController extends BaseController
{
    use AuthorizesRequests;

    public function __construct(private readonly AppointmentService $appointmentService) {}

    /**
     * @OA\Post(
     *     path="/api/appointment/view",
     *     summary="View Appointments",
     *     description="Retrieves a list of appointments for the authenticated user",
     *     tags={"Appointments"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Appointments retrieved successfully",
     *     ),
     * )
     */
    public function view(): JsonResponse
    {
        try {
            $appointments = $this->appointmentService->getAppointmentsByUserId(request()->user()?->id);

            return $this->successResponse(
                result: $appointments,
                message: 'Appointments Retrieved Successfully.'
            );
        } catch (\Exception $exception) {
            Log::critical($exception->getMessage());

            return $this->errorResponse(
                error: 'Error while fetching Appointment. Please try again.',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/appointment/book",
     *     summary="Book Appointment",
     *     description="Allows the authenticated user to book an appointment",
     *     tags={"Appointments"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *                 required={"healthcare_professional_id", "time"},
     *
     *                 @OA\Property(
     *                     property="healthcare_professional_id",
     *                     type="integer",
     *                     description="The ID of the healthcare professional"
     *                 ),
     *                 @OA\Property(
     *                     property="time",
     *                     type="string",
     *                     format="date-time",
     *                     example="31-05-2025 13:00:00",
     *                     description="The time for the appointment"
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Appointment booked successfully",
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Slot already booked for the given time. Please choose another time.",
     *     ),
     * )
     */
    public function book(BookRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = \request()->user()?->id;

            $result = $this->appointmentService->bookAppointment($data);

            if (is_string($result)) {
                return $this->errorResponse(
                    error: $result,
                    code: Response::HTTP_CONFLICT
                );
            }

            return $this->successResponse(
                result: $result,
                message: 'Appointment Booked Successfully.'
            );

        } catch (\Exception $exception) {
            Log::critical($exception->getMessage());

            return $this->errorResponse(
                error: 'An error occurred while booking the appointment. Please try again.',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Get(
     *     path="/api/appointment/cancel/{appointment}",
     *     summary="Cancel Appointment",
     *     description="Allows the authenticated user to cancel an appointment",
     *     tags={"Appointments"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="appointment",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer"),
     *         description="The ID of the appointment"
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Appointment cancelled successfully",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Appointment is already cancelled.",
     *     ),
     * )
     */
    public function cancel(Appointment $appointment): JsonResponse
    {
        $this->authorize('cancel', $appointment);

        try {
            $result = $this->appointmentService->cancelAppointment($appointment);

            if (is_string($result)) {
                return $this->errorResponse(
                    error: $result,
                    code: Response::HTTP_FORBIDDEN
                );
            }

            return $this->successResponse(
                result: $result,
                message: 'Appointment Cancelled Successfully.'
            );

        } catch (\Exception $e) {
            Log::error('Error cancelling appointment: '.$e->getMessage());

            return $this->errorResponse(
                error: 'An error occurred while cancelling the appointment. Please try again.',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Get(
     *     path="/api/appointment/complete/{appointment}",
     *     summary="Complete Appointment",
     *     description="Allows the authenticated user to complete an appointment",
     *     tags={"Appointments"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="appointment",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer"),
     *         description="The ID of the appointment"
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Appointment completed successfully",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Appointment is already completed.",
     *     ),
     * )
     */
    public function complete(Appointment $appointment): JsonResponse
    {
        $this->authorize('complete', $appointment);

        try {
            $result = $this->appointmentService->completeAppointment($appointment);

            if (is_string($result)) {
                return $this->errorResponse(
                    error: $result,
                    code: Response::HTTP_FORBIDDEN
                );
            }

            return $this->successResponse(
                result: $result,
                message: 'Appointment Completed Successfully.'
            );

        } catch (\Exception $e) {
            Log::error('Error completing appointment: '.$e->getMessage());

            return $this->errorResponse(
                error: 'An error occurred while completing the appointment. Please try again.',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

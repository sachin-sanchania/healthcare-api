<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointment\BookRequest;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AppointmentController extends BaseController
{
    use AuthorizesRequests;

    public function __construct(private readonly AppointmentService $appointmentService) {}

    /**
     * View appointments for a user.
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
     * Book an appointment.
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
     * Cancel an appointment.
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
     * Complete an appointment.
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

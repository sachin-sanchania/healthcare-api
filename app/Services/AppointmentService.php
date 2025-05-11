<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Illuminate\Support\Carbon;

class AppointmentService extends BaseService
{
    /**
     * Get the base model class for healthcare professional related operations.
     */
    public function baseModel(): string
    {
        return Appointment::class;
    }

    /**
     * Get all appointments for a specific user.
     */
    public function getAppointmentsByUserId(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return Appointment::with([
            'user:id,name,email',
            'healthcareProfessional:id,name,speciality',
        ])
            ->where('user_id', $userId)
            ->select('id', 'appointment_start_time', 'appointment_end_time', 'status', 'user_id', 'healthcare_professional_id')
            ->get();
    }

    /**
     * Book an appointment for a specific user.
     */
    public function bookAppointment(array $data): Appointment|string
    {
        $appointmentTime = Carbon::parse($data['time']);

        $isSlotBooked = Appointment::where('healthcare_professional_id', $data['healthcare_professional_id'])
            ->where('appointment_start_time', '<=', $appointmentTime)
            ->where('appointment_end_time', '>', $appointmentTime)
            ->where('status', '!=', AppointmentStatus::Cancelled->value)
            ->exists();

        if ($isSlotBooked) {
            return 'Slot already booked for the given time. Please choose another time.';
        }

        return Appointment::create([
            'user_id' => $data['user_id'],
            'healthcare_professional_id' => $data['healthcare_professional_id'],
            'appointment_start_time' => $appointmentTime,
            'appointment_end_time' => $appointmentTime->copy()->addHour(),
            'status' => AppointmentStatus::Booked->value,
        ]);
    }

    /**
     * Cancel an appointment for a specific user.
     */
    public function cancelAppointment($appointment): Appointment|string
    {
        if ($appointment->status === AppointmentStatus::Cancelled) {
            return 'Appointment is already cancelled.';
        }

        $cancellationDeadline = Carbon::parse($appointment->appointment_start_time)->subHours(24);
        $currentTime = Carbon::now();

        if ($appointment->status === AppointmentStatus::Booked && $currentTime->lte($cancellationDeadline)) {
            return 'Cancellation is not allowed within 24 hours of the appointment.';
        }

        $appointment->status = AppointmentStatus::Cancelled->value;
        $appointment->save();

        return $appointment;
    }

    /**
     * Complete an appointment for a specific user.
     */
    public function completeAppointment($appointment): Appointment|string
    {
        if ($appointment->status === AppointmentStatus::Completed) {
            return 'Appointment is already completed.';
        }

        $appointment->status = AppointmentStatus::Completed->value;
        $appointment->save();

        return $appointment;
    }
}

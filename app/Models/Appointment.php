<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'healthcare_professional_id',
        'appointment_start_time',
        'appointment_end_time',
        'status',
    ];

    protected $casts = [
        'appointment_start_time' => 'datetime',
        'appointment_end_time' => 'datetime',
        'status' => AppointmentStatus::class,
    ];

    /**
     * Get the user associated with this appointment.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the healthcare professional associated with this appointment.
     */
    public function healthcareProfessional(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(HealthcareProfessional::class);
    }
}

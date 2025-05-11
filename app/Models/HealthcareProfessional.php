<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthcareProfessional extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'speciality',
    ];

    /**
     * Get all appointments associated with this model.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}

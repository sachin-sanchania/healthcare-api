<?php

namespace App\Services;

use App\Models\HealthcareProfessional;

class HealthcareProfessionalService extends BaseService
{
    /**
     * Get the base model class for healthcare professional related operations.
     */
    public function baseModel(): string
    {
        return HealthcareProfessional::class;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return HealthcareProfessional::query()->orderBy('name')->get([
            'id',
            'name',
            'speciality',
            'created_at',
        ]);
    }
}

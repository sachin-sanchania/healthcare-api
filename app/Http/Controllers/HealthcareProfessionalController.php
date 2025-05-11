<?php

namespace App\Http\Controllers;

use App\Services\HealthcareProfessionalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class HealthcareProfessionalController extends BaseController
{
    public function __construct(readonly HealthcareProfessionalService $healthcareProfessionalService) {}

    /**
     * Display a listing of the healthcare professionals.
     */
    public function index(): JsonResponse
    {
        try {
            $professionals = $this->healthcareProfessionalService->getAll();

            return $this->successResponse(
                result: $professionals,
                message: 'Healthcare professionals retrieved successfully.'
            );
        } catch (\Exception $e) {
            Log::critical($e->getMessage());

            return $this->errorResponse(
                error: $e->getMessage(),
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

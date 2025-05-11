<?php

namespace App\Http\Requests\Appointment;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'healthcare_professional_id' => 'required|integer|exists:healthcare_professionals,id',
            'time' => 'required|date_format:d-m-Y H:i:s',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    protected function failedValidation(Validator $validator): array
    {
        $base = new BaseController;

        throw new HttpResponseException(
            $base->errorResponse(
                error: $base->error_processor($validator),
                code: 422
            )
        );
    }

    /**
     * Additional validation after the main validation rules have been applied.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $appointmentTime = Carbon::parse($this->input('time'));

            if ($appointmentTime->isPast()) {
                $validator->errors()->add('time', 'Cannot book an appointment for a past date. Please choose a future date.');
            }
        });
    }
}

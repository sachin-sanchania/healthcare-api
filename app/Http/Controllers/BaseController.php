<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * success response method.
     */
    public function successResponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     */
    public function errorResponse($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'error' => $error,
            'code' => $code,
        ];
        if (! empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * Send Invalid response for invalid data of api.
     */
    public function errorInvalidResponse(): JsonResponse
    {
        $response = [
            'success' => false,
            'error' => 'Invalid Data.',
            'code' => 422,
        ];

        return response()->json($response, 422);
    }

    public function error_processor($validator): array
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            $err_keeper[] = ['name' => $index, 'message' => $error[0]];
        }

        return $err_keeper;
    }
}

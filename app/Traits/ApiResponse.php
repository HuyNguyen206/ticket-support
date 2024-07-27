<?php

namespace App\Traits;

trait ApiResponse
{
    protected function success($message = 'success', $data = [], $statusCode = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => $statusCode,
        ], $statusCode);
    }

    protected function error(string|array $message = 'error', $statusCode = 500)
    {
        if (is_string($message)) {
            return response()->json([
                'message' => $message,
                'status' => $statusCode,
            ], $statusCode);
        }

        return response()->json([
            'errors' => $message,
        ], $statusCode);

    }
}

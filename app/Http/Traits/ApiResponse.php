<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function success(mixed $data = null, string $message = 'OK', int $status = 200): JsonResponse
    {
        $payload = ['success' => true, 'message' => $message];
        if (!is_null($data)) {
            $payload['data'] = $data;
        }
        return response()->json($payload, $status);
    }

    protected function error(string $message, int $status = 400, array $errors = []): JsonResponse
    {
        $payload = ['success' => false, 'message' => $message];
        if (!empty($errors)) {
            $payload['errors'] = $errors;
        }
        return response()->json($payload, $status);
    }

    protected function paginated(mixed $paginator, string $message = 'OK'): JsonResponse
    {
        return response()->json([
            'success'    => true,
            'message'    => $message,
            'data'       => $paginator->items(),
            'pagination' => [
                'total'        => $paginator->total(),
                'per_page'     => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],
        ]);
    }
}

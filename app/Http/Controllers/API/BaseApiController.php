<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    protected function success(string $message, $data = null, int $code = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function error(string $message, int $code = 400, $errors = null)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors,
            'data'    => null,
        ], $code);
    }

    protected function paginated(string $message, $paginator)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $paginator->items(),
            'meta'    => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
        ]);
    }
}

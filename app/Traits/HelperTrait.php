<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait HelperTrait
{
    /**
     * Build success response
     *
     * @param  array|null  $data
     * @param  string|null  $message
     * @param  array|null  $info
     * @param  array|null  $warning
     * @param  array|null  $error
     * @param  int  $code
     * @return JsonResponse
     */
    public function successResponse(
        $code = 200,
        $data = null,
        $message = null,
        $info = null,
        $warning = null,
        $error = null
    ): JsonResponse {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'info' => $info,
            'warning' => $warning,
            'error' => $error,
            'code' => $code,
        ], $code);
    }

    /**
     * Build valide response
     *
     * @param  string|array  $message
     * @param  int  $code
     * @return Response
     */
    public function successMessage($message, $code): Response
    {
        return response($message, $code)->header('Content-Type', 'application/json');
    }

    /**
     * Build error response
     *
     * @param  array|null  $data
     * @param  string|null  $message
     * @param  array|null  $info
     * @param  array|null  $warning
     * @param  array|null  $error
     * @param  int  $code
     * @return JsonResponse
     */
    public function errorResponse(
        $code = 400,
        $data = null,
        $message = null,
        $info = null,
        $warning = null,
        $error = null
    ): JsonResponse {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'info' => $info,
            'warning' => $warning,
            'error' => $error,
            'code' => $code,
        ], $code);
    }

    /**
     * Build error response
     *
     * @param  string|array  $message
     * @param  int  $code
     * @return Response
     */
    public function errorMessage($message, int $code): Response
    {
        return response($message, (int)$code)->header('Content-Type', 'application/json');
    }
}

?>

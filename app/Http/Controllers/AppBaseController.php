<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message, $errorMessage)
    {
        return Response::json([
            'success' => true,
            'data' => $result,
            'message' => $message,
            'errorMessage' => $errorMessage,
        ]);
    }

    public function sendError($result, $message, $errorMessage)
    {
        return Response::json([
            'success' => true,
            'data' => $result,
            'message' => $message,
            'errorMessage' => $errorMessage,
        ]);
    }

    public function sendSuccess($result, $message, $errorMessage)
    {
        return Response::json([
            'success' => true,
            'data' => $result,
            'message' => $message,
            'errorMessage' => $errorMessage,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function getResponseAnswer(bool $status, string|array $message, array|object $data = null, int $statusCode)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
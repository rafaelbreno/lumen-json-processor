<?php


namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $request->toArray()
        ], 200);
    }
}

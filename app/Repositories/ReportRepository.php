<?php


namespace App\Repositories;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportRepository implements ReportRepositoryInterface
{
    public function requestPerConsumer(Request $request): JsonResponse
    {
        return response()->json();
    }

    public function requestPerService(Request $request): JsonResponse
    {
        return response()->json();
    }

    public function averageLatencyPerService(Request $request): JsonResponse
    {
        return response()->json();
    }
}

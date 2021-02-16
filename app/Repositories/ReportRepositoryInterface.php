<?php

namespace App\Repositories;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ReportRepositoryInterface
{
    public function requestPerConsumer(Request $request): JsonResponse;

    public function requestPerService(Request $request): JsonResponse;

    public function averageLatencyPerService(Request $request): JsonResponse;
}

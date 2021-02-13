<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface LogRepositoryInterface
{
    public function create(Request $request): JsonResponse;
}

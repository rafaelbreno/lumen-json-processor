<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ImportFileRepositoryInterface
{
    public function import(Request $request): JsonResponse;
}

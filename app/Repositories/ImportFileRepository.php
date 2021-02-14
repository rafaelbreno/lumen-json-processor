<?php


namespace App\Repositories;


use App\Interfaces\ImportFileRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImportFileRepository implements ImportFileRepositoryInterface
{
    public function import(Request $request): JsonResponse
    {
        return response()->json(["a"], 200);
    }
}

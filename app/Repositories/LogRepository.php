<?php


namespace App\Repositories;


use App\Interfaces\LogRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogRepository implements LogRepositoryInterface
{
    public function create(Request $request): JsonResponse
    {

    }
}

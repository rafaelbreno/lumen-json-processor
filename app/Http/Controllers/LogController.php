<?php


namespace App\Http\Controllers;


use App\Interfaces\LogRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * @var LogRepositoryInterface
     */
    private LogRepositoryInterface $logRepository;

    public function __construct(LogRepositoryInterface $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    public function create(Request $request): JsonResponse
    {
        return $this->logRepository->create($request);
    }
}

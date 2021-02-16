<?php


namespace App\Http\Controllers;



use App\Repositories\ReportRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * @var ReportRepositoryInterface
     */
    private ReportRepositoryInterface $interface;

    public function __construct(ReportRepositoryInterface $interface)
    {
        $this->interface = $interface;
    }

    public function requestPerConsumer(Request $request): JsonResponse
    {
        return $this->interface
                    ->requestPerConsumer($request);
    }

    public function requestPerService(Request $request): JsonResponse
    {
        return $this->interface
                    ->requestPerService($request);
    }

    public function averageLatencyPerService(Request $request): JsonResponse
    {
        return $this->interface
                    ->averageLatencyPerService($request);
    }
}

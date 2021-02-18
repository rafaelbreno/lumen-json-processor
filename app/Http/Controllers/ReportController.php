<?php


namespace App\Http\Controllers;



use App\Repositories\ReportRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function requestPerConsumer(Request $request): StreamedResponse
    {
        return $this->interface
                    ->requestPerConsumer($request);
    }

    public function requestPerService(Request $request): StreamedResponse
    {
        return $this->interface
                    ->requestPerService($request);
    }

    public function averageLatencyPerService(Request $request): StreamedResponse
    {
        return $this->interface
                    ->averageLatencyPerService($request);
    }
}

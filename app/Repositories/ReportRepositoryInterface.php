<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface ReportRepositoryInterface
{
    public function requestPerConsumer(Request $request): StreamedResponse;

    public function requestPerService(Request $request): StreamedResponse;

    public function averageLatencyPerService(Request $request): StreamedResponse;
}

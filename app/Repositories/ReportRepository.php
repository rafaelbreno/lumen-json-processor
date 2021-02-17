<?php


namespace App\Repositories;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportRepository implements ReportRepositoryInterface
{
    public function requestPerConsumer(Request $request): JsonResponse
    {
        // Raw SQL faster than Eloquent
        $data = \DB::select("
            SELECT
                   consumer_id,
                   COUNT(id) as quantity
            FROM entities
            GROUP BY consumer_id
        ");
//        $test = Entity::all()
//            ->groupBy('consumer_id')
//            ->map(function ($value, $key) {
//                return count($value);
//            })
//            ->toArray();

        return response()->json($data);
    }

    public function requestPerService(Request $request): JsonResponse
    {
        $data = \DB::select("
            SELECT
                   service_id,
                   COUNT(id) as quantity
            FROM logs
            GROUP BY service_id
        ");

//        $test = Log::all()
//            ->groupBy('service_id')
//            ->map(function ($value, $key) {
//                return count($value);
//            })
//            ->toArray();
        return response()->json($data);
    }

    public function averageLatencyPerService(Request $request): JsonResponse
    {
        $data = \DB::select("
            SELECT
                services.id,
                AVG(latencies.proxy) as avg_proxy,
                AVG(latencies.gateway) avg_gateway,
                AVG(latencies.request) avg_request
            FROM services
            INNER JOIN logs
                ON services.id = logs.service_id
            INNER JOIN latencies
                ON logs.latency_id = latencies.id
            WHERE services.id = logs.service_id
            GROUP BY id
        ");

        return response()->json($data);
    }
}

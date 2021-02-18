<?php


namespace App\Repositories;


use App\Helpers\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportRepository implements ReportRepositoryInterface
{
    private array $data;

    public function requestPerConsumer(Request $request): StreamedResponse
    {
        // Raw SQL faster than Eloquent
        $this->data = DB::select("
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

        return $this->streamedResponse([
            'consumer_id' => 'consumer_id',
            'quantity' => 'quantity',
        ]);
    }

    public function requestPerService(Request $request): StreamedResponse
    {
        $this->data = DB::select("
            SELECT
                   service_id,
                   COUNT(id) as quantity
            FROM logs
            GROUP BY service_id
        ");

        return $this->streamedResponse([
            'service_id' => 'service_id',
            'quantity' => 'quantity',
        ]);
    }

    public function averageLatencyPerService(Request $request): StreamedResponse
    {
        $this->data = DB::select("
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

        return $this->streamedResponse([
            'id' => 'service_id',
            'avg_proxy' => 'proxy',
            'avg_gateway' => 'gateway',
            'avg_request' => 'request',
        ]);
    }

    private function convertToArray(array $arr): array
    {
        return array_map(function ($value) {
            return (array)$value;
        }, $arr);
    }

    private function streamedResponse(array $columns, string $name = 'foo'): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $this->data = $this->convertToArray($this->data);

        $export = (new Export($this->data, $name))
            ->csv($columns);


        return response()->stream($export->callback, 200, $export->headers);
    }
}

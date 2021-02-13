<?php


namespace App\Repositories;


use App\Interfaces\LogRepositoryInterface;
use App\Models\Entity;
use App\Models\Header;
use App\Models\Latency;
use App\Models\Log;
use App\Models\Response;
use App\Models\Route;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class LogRepository
 * @package App\Repositories
 */
class LogRepository implements LogRepositoryInterface
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var JsonResponse
     */
    private JsonResponse $response;
    private array $requestArray;

    /**
     * Method to insert single log
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $this->request = $request;
        $this->requestArray = $request->toArray();

        $this->parseSinglePayload();

        return $this->response;
    }

    /**
     *
     *
     * @param array $data
     * @param int $status
     */
    private function setResponse(array $data, int $status = 200): void
    {
        $this->response = response()->json($data, $status);
    }

    /**
     * Parse JSON and insert into DB
     *
     */
    private function parseSinglePayload(): void
    {
        $validation = $this->validate();
        // Return validation errors
        if ($validation->fails()) {
            $this->setResponse($validation->errors()->toArray(), 403);
            return;
        }

        $this->createLog();
    }

    private function createLog(): void
    {
        $logData = [
            'upstream_uri' => $this->request['upstream_uri'],
            'client_ip' => $this->request['client_ip'],
            'started_at' => Carbon::createFromTimestamp($this->requestArray['started_at'])->format('Y-m-d H:i:s'),

            'request_id' => $this->createRequest(),
            'entity_id' => $this->createEntity(),
            'response_id' => $this->createResponse(),
            'route_id' => $this->createRoute(),
            'service_id' => $this->createService(),
            'latency_id' => $this->createLatency(),
        ];

        $log = Log::create($logData);

        $this->setResponse($logData, 200);
    }

    private function createRequest(): int
    {
        $requestData = $this->requestArray['request'];

        $requestData['header_id'] = $this->createHeader($requestData['headers']);

        $request = \App\Models\Request::create($requestData);

        return $request->id;
    }

    private function createEntity(): int
    {
        /*
         *  "authenticated_entity":{
         *      "consumer_id":{
         *          "uuid":"72b34d31-4c14-3bae-9cc6-516a0939c9d6"
         *      }
         *  },
         * */

        $entity = Entity::create([
            'consumer_id' => $this->requestArray['authenticated_entity']['consumer_id']['uuid']
        ]);

        return $entity->id;
    }

    private function createResponse(): int
    {
        $responseData = $this->requestArray['response'];
        $responseData['header_id'] = $this->createHeader($this->requestArray['response']['headers']);

        $response = Response::create($responseData);

        return $response->id;
    }

    private function createRoute(): string
    {
        $data = $this->getRouteData();
        $route = Route::firstOrCreate(['id' => $data['id']], $data);
        return $route->id;
    }

    private function getRouteData(): array
    {
        $routeData = $this->requestArray['route'];
        return [
            'hosts' => $routeData['hosts'],
            'id' => $routeData['id'],
            'methods' => serialize($routeData['methods']),
            'paths' => serialize($routeData['paths']),
            'preserve_host' => (bool)$routeData['preserve_host'],
            'protocols' => serialize($routeData['protocols']),
            'regex_priority' => (int)$routeData['regex_priority'],
            'service_id' => $routeData['service']['id'],
            'strip_path' => (bool)$routeData['strip_path'],
            'created_at' => Carbon::createFromTimestamp($routeData['created_at'])->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::createFromTimestamp($routeData['updated_at'])->format('Y-m-d H:i:s'),
        ];
    }

    private function createService(): string
    {
        $data = $this->getServiceData();
        $service = Service::firstOrCreate(['id' => $data['id']], $data);

        return $service->id;
    }

    private function getServiceData(): array
    {
        $data = $this->requestArray['service'];
        $data['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format('Y-m-d H:i:s');
        $data['created_at'] = Carbon::createFromTimestamp($data['created_at'])->format('Y-m-d H:i:s');

        return $data;
    }

    private function createLatency(): string
    {
        $latency = Latency::create($this->requestArray['latencies']);

        return $latency->id;
    }

    private function createHeader(array $data): string
    {
        $header = Header::create($data);

        return $header->id;
    }

    /**
     * Validate given JSON
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validate(): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($this->requestArray, $this->logRules());
    }

    /**
     * @return array
     */
    private function logRules(): array
    {
        return array_merge([
            "upstream_uri" => [
                'required', 'string'
            ],
            "client_ip" => [
                'required' => 'ip'
            ],
            "started_at" => [
                'required' => 'int'
            ]
        ], $this->requestRules(), $this->responseRules(), $this->entityRules(),
           $this->routeRules() ,$this->serviceRules(), $this->latencyRules());
    }

    /**
     * Request fields rules
     *
     * @return array
     */
    private function requestRules(): array
    {
        return [
            'request' => [
                'required', 'array'
            ],
            'request.method' => [
                'required', 'string',
                Rule::in(["GET","POST","PUT","DELETE","PATCH","OPTIONS","HEAD"]),
            ],
            'request.uri' => [
                'required', 'string'
            ],
            'request.url' => [
                'required', 'string'
            ],
            'request.size' => [
                'required', 'integer'
            ],
            'request.querystring' => [
                'required', 'string'
            ],
            'request.headers' => [
                'required', 'array'
            ],
            'request.headers.accept' => [
                'required', 'string'
            ],
            'request.headers.host' => [
                'required', 'string'
            ],
            'request.headers.user-agent' => [
                'required', 'string'
            ],
        ];
    }

    /**
     * Response fields rules
     *
     * @return string[][]
     */
    private function responseRules(): array
    {
        return [
            'response' => [
                'required', 'array'
            ],
            'response.status' => [
                'required', 'integer'
            ],
            'response.size' => [
                'required', 'integer'
            ],
            'response.headers' => [
                'required', 'array'
            ],
            'response.headers.Content-Length' => [
                'required', 'integer'
            ],
            'response.headers.via' => [
                'required', 'string'
            ],
            'response.headers.Connection' => [
                'required', 'string'
            ],
            'response.headers.access-control-allow-credentials' => [
                'required',
                Rule::in('true', 'false' , true, false, 1, 0)
            ],
            'response.headers.Content-Type' => [
                'required', 'string'
            ],
            'response.headers.server' => [
                'required', 'string'
            ],
            'response.headers.access-control-allow-origin' => [
                'required', 'string'
            ],
        ];
    }

    /**
     * Entity fields rules
     *
     * @return string[][]
     */
    private function entityRules(): array
    {
        return [
            'authenticated_entity' => [
                'required', 'array'
            ],
            'authenticated_entity.consumer_id.uuid' => [
                'required', 'uuid'
            ],
        ];
    }

    /**
     * Route fields rules
     *
     * @return string[][]
     */
    private function routeRules(): array
    {
        return [
            'route' => [
                'required', 'array'
            ],
            'route.hosts' => [
                'required', 'string'
            ],
            'route.id' => [
                'required', 'uuid'
            ],
            'route.methods' => [
                'required', 'array'
            ],
            'route.paths' => [
                'required', 'array'
            ],
            'route.preserve_host' => [
                'required', 'boolean'
            ],
            'route.protocols' => [
                'required', 'array'
            ],
            'route.regex_priority' => [
                'required', 'integer'
            ],
            'route.service.id' => [
                'required', 'uuid'
            ],
            'route.strip_path' => [
                'required', 'boolean'
            ],
            'route.created_at' => [
                'required', 'integer'
            ],
            'route.updated_at' => [
                'required', 'integer'
            ],
        ];
    }

    /**
     * Service fields rules
     *
     * @return string[][]
     */
    private function serviceRules(): array
    {
        return [
            'service' => [
                'required', 'array'
            ],
            'service.host' => [
                'required', 'string'
            ],
            'service.id' => [
                'required', 'uuid'
            ],
            'service.name' => [
                'required', 'string'
            ],
            'service.path' => [
                'required', 'string'
            ],
            'service.port' => [
                'required', 'integer'
            ],
            'service.protocol' => [
                'required', 'string'
            ],
            'service.retries' => [
                'required', 'integer'
            ],
            'service.read_timeout' => [
                'required', 'integer'
            ],
            'service.connect_timeout' => [
                'required', 'integer'
            ],
            'service.write_timeout' => [
                'required', 'integer'
            ],
            'service.created_at' => [
                'required', 'integer'
            ],
            'service.updated_at' => [
                'required', 'integer'
            ],
        ];
    }

    /**
     * Latency fields rules
     *
     * @return string[][]
     */
    private function latencyRules(): array
    {
        return [
            'latencies' => [
                'required', 'array'
            ],
            'latencies.proxy' => [
                'required', 'integer'
            ],
            'latencies.gateway' => [
                'required', 'integer'
            ],
            'latencies.request' => [
                'required', 'integer'
            ]
        ];
    }
}

<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Log extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_id', 'entity_id', 'response_id',
        'route_id', 'service_id', 'latency_id',

        'upstream_uri', 'client_ip', 'started_at',
    ];

    // Relationships

    public function latency(): HasOne
    {
        return $this->hasOne(Latency::class, 'latency_id', 'id');
    }

    public function service(): HasOne
    {
        return $this->hasOne(Service::class, 'service_id', 'id');
    }

    public function route(): HasOne
    {
        return $this->hasOne(Route::class, 'route_id', 'id');
    }

    public function response(): HasOne
    {
        return $this->hasOne(Response::class, 'response_id', 'id');
    }

    public function entity(): HasOne
    {
        return $this->hasOne(Entity::class, 'entity_id', 'id');
    }

    public function request(): HasOne
    {
        return $this->hasOne(Request::class, 'request_id', 'id');
    }

    static public function validationRules(): array
    {
        return [
            "upstream_uri" => [
                'required', 'string'
            ],
            "client_ip" => [
                'required' => 'ip'
            ],
            "started_at" => [
                'required' => 'int'
            ]
        ];
    }
}

<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

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
}

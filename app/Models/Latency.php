<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Latency extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'latencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'proxy', 'gateway', 'request',
    ];

    static public function validationRules(): array
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

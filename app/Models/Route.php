<?php


namespace App\Models;


use App\Traits\SetupUuid;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use SetupUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'routes';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'hosts', 'methods', 'paths', 'preserve_host',
        'protocols', 'regex_priority', 'strip_path',

        'service_id',
    ];

    protected $casts = [
        'methods' => 'array',
        'paths' => 'array',
    ];

    static public function validationRules(): array
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
}

<?php


namespace App\Models;


use App\Traits\SetupUuid;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use SetupUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'host', 'name', 'path', 'port', 'protocol', 'retries',
        'connect_timeout', 'read_timeout', 'write_timeout',
    ];

    static public function validationRules(): array
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
}

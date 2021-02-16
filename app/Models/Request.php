<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\Rule;

class Request extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'requests';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'method', 'uri', 'url', 'size', 'querystring',

        'header_id',
    ];

    protected $casts = [
        'querystring' => 'array'
    ];

    public function header(): HasOne
    {
        return $this->hasOne(Header::class, 'header_id', 'id');
    }

    static public function validationRules(): array
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
                'nullable', 'array'
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
}

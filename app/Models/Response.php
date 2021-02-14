<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\Rule;

class Response extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'responses';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'size',

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
}

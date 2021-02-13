<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

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
}

<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
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
}

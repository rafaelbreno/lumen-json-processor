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
}

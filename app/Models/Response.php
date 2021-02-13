<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

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
}

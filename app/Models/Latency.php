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
}

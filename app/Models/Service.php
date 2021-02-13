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
}

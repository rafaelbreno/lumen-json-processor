<?php


namespace App\Models;


use App\Traits\SetUuid;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    use SetUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'headers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content_length', 'via', 'connection', 'access_control_allow_credentials',
        'content_type', 'server', 'accept', 'host', 'user_agent',
    ];
}

<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}

<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ImportErrors extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_files';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'error', 'type',

        'log_file_id',
    ];

    protected $casts = [
        'error' => 'array'
    ];
}

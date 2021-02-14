<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LogFiles extends Model
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
        'filename', 'status',
    ];

    protected $casts = [
        'error' => 'array'
    ];

    public function importErrors(): HasMany
    {
        return $this->hasMany(ImportErrors::class, 'log_file_id', 'id');
    }
}

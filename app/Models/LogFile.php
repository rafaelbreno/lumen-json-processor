<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LogFile extends Model
{
    /* Status
     * -1 Found Errors
     * 0 - Not Processed
     * 1 - Processing
     * 2 - Finished Processing
     * */

    const FOUND_ERRORS = -1,
          NOT_PROCESSED = 0,
          PROCESSING = 1,
          FINISHED = 2;



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

    static public function validationRules(): array
    {
        return [
            'file' => [
                'required', 'file', 'mimes:txt'
            ]
        ];
    }
}

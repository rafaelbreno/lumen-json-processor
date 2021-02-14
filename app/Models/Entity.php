<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'consumer_id'
    ];

    static public function validationRules(): array
    {
        return [
            'authenticated_entity' => [
                'required', 'array'
            ],
            'authenticated_entity.consumer_id.uuid' => [
                'required', 'uuid'
            ],
        ];
    }
}

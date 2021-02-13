<?php


namespace App\Traits;


use Illuminate\Support\Str;

/**
 * Trait SetUuid
 * @package App\Traits
 */
trait SetUuid
{
    use SetupUuid;
    /**
     *
     */
    protected static function bootSetUuid(): void
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string)Str::uuid();
            }
        });
    }
}

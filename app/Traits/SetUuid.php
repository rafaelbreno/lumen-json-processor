<?php


namespace App\Traits;


use Illuminate\Support\Str;

/**
 * Trait SetUuid
 * @package App\Traits
 */
trait SetUuid
{
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

    /**
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}

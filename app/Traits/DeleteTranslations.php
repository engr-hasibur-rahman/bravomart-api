<?php

namespace App\Traits;

trait DeleteTranslations
{
    public static function bootDeleteTranslations()
    {
        static::deleting(function (Model $model) {
            if (method_exists($model, 'translations')) {
                $model->translations()->delete();
            }
        });
    }
}

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

        static::forceDeleted(function (Model $model) {
            // For models that skip `deleting` on forceDelete
            if (method_exists($model, 'translations')) {
                $model->translations()->delete();
            }
        });
    }
}

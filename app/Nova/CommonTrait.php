<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;

trait CommonTrait {

    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }
}

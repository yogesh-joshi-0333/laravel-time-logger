<?php

namespace LaravelTimeLogger\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \LaravelTimeLogger\LaravelTimeLogger start(string $label)
 */
class LaravelTimeLogger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LaravelTimeLogger';
    }
}

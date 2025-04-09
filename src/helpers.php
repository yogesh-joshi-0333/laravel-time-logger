<?php

use LaravelTimeLogger\LaravelTimeLogger;
use Illuminate\Support\Facades\Log;

if (!function_exists('timerlog')) {
    function timerlog(string $label): LaravelTimeLogger
    {
        return new LaravelTimeLogger($label);
    }
}

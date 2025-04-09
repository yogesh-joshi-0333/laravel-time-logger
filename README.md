# Scoped Timer for Laravel

A lightweight Laravel package that helps profile code execution time using RAII-style scoped timing.

## Installation
```bash
composer require yogeshjoshi/laravel-time-logger
```

## Usage
```php

using class

use LaravelTimeLogger\LaravelTimeLogger;

function exportCSV() {
    $timer = new LaravelTimeLogger("Export CSV");
    $timer->start();
    // do work here
    $timer->stop();
}

using helper function 

$timer = timerlog('Helper test');
$timer->start();
// do work here
$timer->stop();


```

## Publishing Config
```bash
php artisan vendor:publish --tag=laravel-time-logger
```

## Config Options
- `log_channel` — Where to log results (default: `daily`)
- `enabled` — Enable or disable timing

---

You're ready to go!

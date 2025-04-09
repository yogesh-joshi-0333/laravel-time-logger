<?php

namespace LaravelTimeLogger\Tests;

use LaravelTimeLogger\LaravelTimeLogger;
use Illuminate\Support\Facades\Log;

class LaravelTimeLoggerTest extends TestCase
{
    public function test_time_logger_execution_time()
    {
        Log::shouldReceive('channel')
            ->once()
            ->andReturnSelf();

        Log::shouldReceive('info')
            ->once()
            ->with(
                \Mockery::pattern('/\[LaravelTimeLogger\] Test block took \d+\.\d{4}s/')
            );

        $timer = new LaravelTimeLogger('Test block');
        $timer->start();
        usleep(100000);
        $timer->end();
    }

    public function test_helper_function_works()
    {
        $timer = time_logger('Helper test');
        $timer->start();
        usleep(100000);
        $timer->end();
        $this->assertInstanceOf(LaravelTimeLogger::class, $timer);
    }
}

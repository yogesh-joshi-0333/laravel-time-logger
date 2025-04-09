<?php

namespace LaravelTimeLogger;

/**
 * LaravelTimeLogger is a simple PHP class for profiling code execution time and memory usage.
 *
 * It allows you to create a timer with a label, and it will log the start and stop times,
 * as well as the memory used during the execution of the code block.
 *
 * Usage:
 * $timer = new LaravelTimeLogger('My Timer');
 * // Your code here
 * unset($timer); // or let it go out of scope
 */

class LaravelTimeLogger
{
    private static int $depth = 0;
    private static string $logPath = __DIR__ . '/../logs/laravelTimeLogger.log';

    private string $label;
    private float $startTime;
    private int $startMemory;
    private bool $logToFile;

    public function __construct(string $label, bool $logToFile = true)
    {
        $this->label = $label;
        $this->logToFile = $logToFile;
        $this->setLogPath();
    }

    public function start()
    {
        $this->startTime = microtime(true);
        $this->startMemory = memory_get_usage();
        self::$depth++;
        $this->log('['.now()->format('Y-m-d H:i:s')."] ⏱️ [START] LaravelTimeLogger for '{$this->label}' | Depth: " . self::$depth . " | Time: " . $this->formatMicrotime($this->startTime));
        return true;
    }

    public function stop()
    {
        $endTime = microtime(true);
        $endMemory = memory_get_usage();

        $elapsed = round(($endTime - $this->startTime) * 1000, 3); // ms
        $memoryUsed = $endMemory - $this->startMemory;
        $memString = $this->formatBytes($memoryUsed);

        $this->log('['.now()->format('Y-m-d H:i:s')."] ✅ [STOP] LaravelTimeLogger for '{$this->label}' | Duration: {$elapsed} ms | Start Time: ".$this->formatMicrotime($this->startTime)." | STOP Time: " .$this->formatMicrotime($endTime).' | Memory Used: '.$memString.' | Depth: ' . self::$depth);

        self::$depth--;
        return true;
    }

    private function log(string $message): void
    {
        $indent = str_repeat("  ", self::$depth - 1);
        $fullMessage = $indent . "[" . date("H:i:s") . "] " . $message . PHP_EOL;

        if ($this->logToFile) {
            file_put_contents(self::$logPath, $fullMessage, FILE_APPEND);
        } else {
            echo $fullMessage;
        }
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes > 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public static function setLogPath(string $path = ''): void
    {
        if (empty($path)) {
            // Use Laravel's storage/logs directory
            $defaultFileName = 'timerlog.log';
            $path = storage_path('logs/' . $defaultFileName);

            // Ensure the logs directory exists
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }

            // Create the log file if it doesn't exist
            if (!file_exists($path)) {
                file_put_contents($path, '');
            }
        }

        self::$logPath = $path;
    }

    public function formatMicrotime($timestamp)
    {
        $dt = \DateTime::createFromFormat('U.u', sprintf('%.6f', $timestamp));
        $dt->setTimezone(new \DateTimeZone(config('app.timezone')));
        return $dt->format('Y-m-d H:i:s.u');
    }

}


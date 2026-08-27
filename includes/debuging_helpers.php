<?php

/**
 * dd function
 * 
 * @param ...$values
 * @return void
 */
if (!function_exists('dd')) {
    function dd(...$values) {
        foreach ($values as $value) {
            echo '<pre>';
            var_dump($value);
            echo '</pre>';
        }
        die();
    }
}
/**
 * app_log function
 * 
 * @param mixed $message
 * @param string $level
 * @return void
 */
if (!function_exists('app_log')) {
    function app_log($message, $level = 'error') {
        $logPath = dirname(__DIR__) . '/storage/logs/app.log';
        $logDir = dirname($logPath);

        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $date = date('Y-m-d H:i:s');
        $level = strtoupper($level);

        if (is_array($message) || is_object($message)) {
            $message = json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $formatted = "[$date] [$level] $message" . PHP_EOL;
        file_put_contents($logPath, $formatted, FILE_APPEND);
    }
}
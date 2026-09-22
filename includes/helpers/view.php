<?php

if (!function_exists('view')) {
    function view(string $path): void
    {
        $filePath = config('view.path') . '/' . str_replace('.', '/', $path) . '.php';

        if (file_exists($filePath)) {
            require $filePath;
        }
    }
}
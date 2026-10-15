<?php

if (!function_exists('view')) {
    function view(string $path): void
    {
        global $validations;
        $filePath = config('view.path') . '/' . str_replace('.', '/', $path) . '.php';

        if (file_exists($filePath)) {
            require $filePath;
        }
    }
}
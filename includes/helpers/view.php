<?php

if (!function_exists('view')) {
    function view(string $path) {
        $currentPath = explode('.', $path);
        $file = end($currentPath);
        $fullPath = '';

        foreach ($currentPath as $path) {
            if (end($currentPath) !== $path) {
                $fullPath .= '/' . $path;
            }
        }

        $fullPath .= '/' . $file . '.php';

        if (file_exists(config('view.path') . $fullPath)) {
            include_once config('view.path') . $fullPath;
        }

        return null;
    }
}
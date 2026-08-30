<?php

if (!function_exists('config')) {
    function config(string $key) {
        $config = explode('.',$key);
        if (count($config) > 0) {
            $result = include __DIR__ . '/../../config/' . $config[0] . '.php';
            return $result[$config[1]] ?? null;
        }
    }
}

if (!function_exists('base_path')) {
    function base_path(string $path) {
        return getcwd() . '/' . $path;
    }
}
<?php

$routes = [];

if (!function_exists('route_get')) {
    function route_get(string $uri, callable $function) {
        global $routes;
        $routes['GET'][$uri] = $function;
    }
}

if (!function_exists('route_post')) {
    function route_post(string $uri, callable $function) {
        global $routes;
        $routes['POST'][$uri] = $function;
    }
}

if (!function_exists('route_put')) {
    function route_put(string $uri, callable $function) {
        global $routes;
        $routes['PUT'][$uri] = $function;
    }
}

if (!function_exists('route_delete')) {
    function route_delete(string $uri, callable $function) {
        global $routes;
        $routes['DELETE'][$uri] = $function;
    }
}

if (!function_exists('segment')) {
    function segment() {
        $uri = '/' . trim($_SERVER['REQUEST_URI'], '/');
        return $uri;
    }
}
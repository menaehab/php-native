<?php

global $routes;

$METHOD = $_SERVER['REQUEST_METHOD'];
$CURRENT_URI = segment();

$ROUTES = $routes[$METHOD] ?? [];

try {
    if (array_key_exists($CURRENT_URI, $ROUTES)) {
        $ROUTES[$CURRENT_URI]();
    } else {
        http_response_code(404);
        echo "404 Not Found";
        exit();
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "500 Internal Server Error: " . $e->getMessage();
    app_log($e->getMessage(), 'error');
    exit();
}
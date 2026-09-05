<?php

route_get('/', function() {
    return view('index');
});

route_get('dashboard', function() {
    return view('dashboard');
});

route_post('/submit', function() {
    $name = $_POST['name'] ?? '';
    echo "Hello, " . htmlspecialchars($name);
});
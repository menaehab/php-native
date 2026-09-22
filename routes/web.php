<?php

route_get('/', function() {
    return view('index');
});

route_get('ar', function() {
    set_session('lang', 'ar');
    return redirect('/');
});

route_get('en', function() {
    set_session('lang', 'en');
    return redirect('/');
});

route_get('dashboard', function() {
    return view('dashboard');
});

route_post('submit', function() {
    $name = $_POST['name'] ?? '';
    echo "Hello, " . htmlspecialchars($name);
});
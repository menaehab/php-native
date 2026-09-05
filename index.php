<?php
ob_start();
require_once __DIR__ . '/includes/app.php';

session_save_path(config('session.save_path'));
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
session_start([
    'cookie_lifetime' => config('session.timeout'),
]);

require_once __DIR__ . '/routes/web.php';
include __DIR__ . "/includes/exception_error.php";

mysqli_close($connect);
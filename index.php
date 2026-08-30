<?php
ob_start();
require_once __DIR__ . '/includes/app.php';

session_start([
    'cookie_lifetime' => config('session.timeout')
]);

require_once __DIR__ . '/routes/web.php';
include __DIR__ . "/includes/exception_error.php";

mysqli_close($connect);
ob_end_flush();
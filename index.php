<?php
ob_start();
session_start();

require_once __DIR__ . '/includes/app.php';

echo config('session.timeout');

mysqli_close($connect);
ob_end_flush();
<?php
ob_start();

$database_info = include __DIR__ . '/../config/database.php';

try {

    $connect = mysqli_connect(
        $database_info['host'],
        $database_info['user'],
        $database_info['password'],
        $database_info['database']
    );


} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}

include __DIR__ . "/helpers/helper.php";


/**
 * set session configuration
 */
session_save_path(config('session.save_path'));
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
session_start([
    'cookie_lifetime' => config('session.timeout'),
]);

require_once __DIR__ . '/../routes/web.php';
include __DIR__ . "/../includes/exception_error.php";

mysqli_close($connect);
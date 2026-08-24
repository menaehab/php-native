<?php

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

include __DIR__ . "/helper.php";
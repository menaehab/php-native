<?php

if (!function_exists('dd')) {
    function dd(...$values) {
        foreach ($values as $value) {
            echo '<pre>';
            var_dump($value);
            echo '</pre>';
        }
        die();
    }
}

if (!function_exists('db_create_table')) {
    function db_create_table($tableName, $columns) {
        global $connect;
        $columns = implode(', ', $columns);
        $query = "CREATE TABLE IF NOT EXISTS $tableName ($columns)";
        if (mysqli_query($connect, $query)) {
            echo "Table $tableName created successfully" . "<br>";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connect);
        }
    }
}

if (!function_exists('db_insert')) {
    function db_insert($tableName, $data) {
        global $connect;
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(function($value) {
            return "'$value'";
        }, array_values($data)));
        $query = "INSERT INTO $tableName ($columns) VALUES ($values)";
        if (mysqli_query($connect, $query)) {
            echo "Data inserted successfully" . "<br>";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connect);
        }
    }
}
<?php
/**
 * dd function
 * 
 * @param ...$values
 * @return void
 */
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
/**
 * app_log function
 * 
 * @param mixed $message
 * @param string $level
 * @return void
 */
if (!function_exists('app_log')) {
    function app_log($message, $level = 'error') {
        $logPath = dirname(__DIR__) . '/storage/logs/app.log';
        $logDir = dirname($logPath);

        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $date = date('Y-m-d H:i:s');
        $level = strtoupper($level);

        if (is_array($message) || is_object($message)) {
            $message = json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $formatted = "[$date] [$level] $message" . PHP_EOL;
        file_put_contents($logPath, $formatted, FILE_APPEND);
    }
}

/**
 * db_create_table function
 * 
 * @param string $tableName
 * @param array $columns
 * @return bool
 */
if (!function_exists('db_create_table')) {
    function db_create_table($tableName, $columns) {
        global $connect;
        $columns = implode(', ', $columns);
        $query = "CREATE TABLE IF NOT EXISTS $tableName ($columns)";
        if (mysqli_query($connect, $query)) {
            return true;
        } else {
            $error = "Error: " . $query . " | MySQL Error: " . mysqli_error($connect);
            app_log($error, 'error');
            echo $error . "<br>";
            return false;
        }
    }
}

/**
 * db_insert function
 * 
 * @param string $tableName
 * @param array $data
 * @return array|bool
 */
if (!function_exists('db_insert')) {
    function db_insert($tableName, $data) {
        global $connect;
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(function($value) {
            return "'$value'";
        }, array_values($data)));
        $query = "INSERT INTO $tableName ($columns) VALUES ($values)";
        if (mysqli_query($connect, $query)) {
            $lastId = mysqli_insert_id($connect);
            $record = mysqli_query($connect, "SELECT * FROM $tableName WHERE id = $lastId");
            return mysqli_fetch_assoc($record);
        } else {
            $error = "Error: " . $query . " | MySQL Error: " . mysqli_error($connect);
            app_log($error, 'error');
            echo $error . "<br>";
            return false;
        }
    }
}

/**
 * db_update function
 * 
 * @param string $tableName
 * @param array $data
 * @param int $id
 * @return array|bool
 */
if (!function_exists('db_update')) {
    function db_update($tableName, $data, $id) {
        global $connect;
        $updates = [];
        foreach ($data as $column => $value) {
            $updates[] = "$column = '$value'";
        }
        $setClause = implode(', ', $updates);
        $query = "UPDATE $tableName SET $setClause WHERE id = $id";
        if (mysqli_query($connect, $query)) {
            $record = mysqli_query($connect, "SELECT * FROM $tableName WHERE id = $id");
            return mysqli_fetch_assoc($record);
        } else {
            $error = "Error: " . $query . " | MySQL Error: " . mysqli_error($connect);
            app_log($error, 'error');
            echo $error . "<br>";
            return false;
        }
    }
}

/**
 * db_delete function
 * 
 * @param string $tableName
 * @param int $id
 * @return bool
 */
if (!function_exists('db_delete')) {
    function db_delete($tableName, $id) {
        global $connect;
        $query = "DELETE FROM $tableName WHERE id = $id";
        if (mysqli_query($connect, $query)) {
            return true;
        } else {
            $error = "Error: " . $query . " | MySQL Error: " . mysqli_error($connect);
            app_log($error, 'error');
            echo $error . "<br>";
            return false;
        }
    }
}

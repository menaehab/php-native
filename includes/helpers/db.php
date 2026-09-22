<?php

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

/**
 * select_all function
 *
 * @param string $tableName
 * @return array|bool
 */
if (!function_exists('select_all')) {
    function select_all($tableName) {
        global $connect;
        $query = "SELECT * FROM $tableName";
        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $error = "Error: " . $query . " | MySQL Error: " . mysqli_error($connect);
            app_log($error, 'error');
            echo $error . "<br>";
            return false;
        }
    }
}

/**
 * find function
 *
 * @param string $tableName
 * @param int $id
 * @return array|bool
 */
if (!function_exists('find')) {
    function find($tableName, $id) {
        global $connect;
        $query = "SELECT * FROM $tableName WHERE id = $id";
        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            $error = "Error: " . $query . " | MySQL Error: " . mysqli_error($connect);
            app_log($error, 'error');
            echo $error . "<br>";
            return false;
        }
    }
/**
 * first function
 *
 * @param string $tableName
 * @param string $column
 * @param string $value
 * @return array|bool
 */
if (!function_exists('first')) {
    function first($tableName, $column, $value) {
        global $connect;
        $query = "SELECT * FROM $tableName WHERE $column = $value LIMIT 1";
        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
            } else {
                $error = "Error: " . $query . " | MySQL Error: " . mysqli_error($connect);
                app_log($error, 'error');
                echo $error . "<br>";
                return false;
            }
        }
    }
}



if (!function_exists('where'))
{
    function where($tableName, $column, $value)
    {
        global $connect;
        $query = "SELECT * FROM $tableName WHERE $column = $value";
        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $error = "Error: " . $query . " | MySQL Error: " . mysqli_error($connect);
            app_log($error, 'error');
            echo $error . "<br>";
            return false;
        }
    }
}

if (!function_exists("paginate"))
{
    function paginate($tableName, $perPage = 10, $pageq = 1)
    {
        global $connect;
        $query = "SELECT * FROM $tableName";
        $result = mysqli_query($connect, $query);
        $total = mysqli_num_rows($result);
        $pages = ceil($total / $perPage);
        $current = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($current - 1) * $perPage;
        $query = "SELECT * FROM $tableName LIMIT $start, $perPage";
        $result = mysqli_query($connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

<?php

if(!function_exists('session')) {
    function session(string $key, $value) {
        $_SESSION[$key] = $value;
    }
}

if(!function_exists('get_session')) {
    function get_session(string $key) {
        return $_SESSION[$key];
    }
}

if(!function_exists('delete_session')) {
    function delete_session(string $key) {
        session_unset($key);
    }
}

if (!function_exists('flash_all_sessions')) {
    function flash_all_sessions() {
        session_destroy();
    }
}
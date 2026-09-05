<?php

if(!function_exists('session')) {
    function session(string $key, $value) {
        $_SESSION[$key] = $value;
    }
}

if(!function_exists('set_session')) {
    function set_session(string $key, $value) {
        $_SESSION[$key] = $value;
    }
}

if(!function_exists('get_session')) {
    function get_session(string $key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
}

if(!function_exists('delete_session')) {
    function delete_session(string $key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
}

if (!function_exists('flash_all_sessions')) {
    function flash_all_sessions() {
        session_destroy();
    }
}
<?php

if(!function_exists('session')) {
    function session(?string $key = null, $value = null) {
        // session() with no args -> return manager with set/get (fixes validations.php:58)
        if ($key === null) {
            return new class {
                public function set(string $k, $v) { set_session($k, $v); return $v; }
                public function get(string $k, $default = null) { return get_session($k, $default); }
                public function has(string $k): bool { return isset($_SESSION[$k]); }
                public function forget(string $k): void { delete_session($k); }
                public function all(): array { return $_SESSION ?? []; }
            };
        }
        // session('key') -> get, session('key', 'value') -> set (Laravel-style)
        if (func_num_args() === 1) {
            return get_session($key);
        }
        set_session($key, $value);
        return $value;
    }
}

if(!function_exists('set_session')) {
    function set_session(string $key, $value) {
        // serialize so arrays (e.g. validations) can be encrypted (openssl needs string)
        $_SESSION[$key] = encrypt(serialize($value));
    }
}

if (!function_exists('get_session')) {
    function get_session(string $key, $default = null)
    {
        if (!isset($_SESSION[$key])) {
            return $default;
        }

        $decrypted = decrypt($_SESSION[$key]);

        if ($decrypted === false) {
            return $default;
        }

        // try to unserialize (new format); fallback to raw string (old plain-string format)
        $unserialized = @unserialize($decrypted);
        if ($unserialized !== false || $decrypted === 'b:0;') {
            return $unserialized;
        }

        return $decrypted ?? $default;
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
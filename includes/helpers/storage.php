<?php

/**
 * storage function
 *
 * Resolve an absolute path inside the configured file storage directory.
 *
 * @param string $path Relative path inside storage (e.g. 'avatars/photo.jpg')
 * @return string Absolute filesystem path
 */
if (!function_exists('storage')) {
    function storage(string $path = '') {
        $base = rtrim(config('files.file_path'), '/');
        $path = trim($path, '/');
        return $path === '' ? $base : $base . '/' . $path;
    }
}

/**
 * store_file function
 *
 * Store a file (plain filesystem path or a $_FILES upload entry) inside storage.
 * Validates extension and size against config/files.php, generates a unique
 * filename to avoid collisions and returns the stored path relative to storage.
 *
 * @param array|string $file $_FILES entry (['tmp_name','name','error','size']) or source path
 * @param string $path Subdirectory inside storage (e.g. 'avatars')
 * @return string|false Relative stored path (e.g. 'avatars/abc_photo.jpg') or false on failure
 */
if (!function_exists('store_file')) {
    function store_file($file, string $path = '') {
        $source = null;
        $originalName = null;
        $size = 0;

        if (is_array($file)) {
            if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                app_log('File upload error code: ' . ($file['error'] ?? 'unknown'), 'error');
                return false;
            }
            if (empty($file['tmp_name']) || !is_file($file['tmp_name'])) {
                app_log('Uploaded tmp file missing: ' . ($file['name'] ?? 'unknown'), 'error');
                return false;
            }
            $source = $file['tmp_name'];
            $originalName = $file['name'] ?? basename($source);
            $size = $file['size'] ?? filesize($source);
        } elseif (is_string($file)) {
            if (!is_file($file)) {
                app_log('Source file not found: ' . $file, 'error');
                return false;
            }
            $source = $file;
            $originalName = basename($file);
            $size = filesize($file);
        } else {
            app_log('store_file expects $_FILES array or source path string.', 'error');
            return false;
        }

        $maxSize = config('files.max_size');
        if ($maxSize && $size > $maxSize) {
            app_log("File too large ({$size} bytes): {$originalName}", 'error');
            return false;
        }

        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = config('files.allowed_extensions') ?? [];
        if (!empty($allowed) && !in_array($extension, $allowed)) {
            app_log("File extension not allowed (.{$extension}): {$originalName}", 'error');
            return false;
        }

        $storagePath = storage($path);
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        $safeBase = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
        $safeBase = trim($safeBase, '._') ?: 'file';
        $filename = uniqid() . '_' . $safeBase . ($extension ? '.' . $extension : '');
        $destination = $storagePath . '/' . $filename;

        $moved = is_uploaded_file($source)
            ? move_uploaded_file($source, $destination)
            : copy($source, $destination);

        if (!$moved) {
            app_log("Failed to store file: {$originalName} -> {$destination}", 'error');
            return false;
        }

        $relative = trim(trim($path, '/') . '/' . $filename, '/');
        return $relative;
    }
}

/**
 * delete_file function
 *
 * Delete a file from storage by its relative path.
 *
 * @param string $path Relative path inside storage
 * @return bool
 */
if (!function_exists('delete_file')) {
    function delete_file(string $path) {
        $absolute = storage($path);
        if (!is_file($absolute)) {
            return false;
        }
        return unlink($absolute);
    }
}

/**
 * storage_exists function
 *
 * Check whether a relative path exists inside storage.
 *
 * @param string $path Relative path inside storage
 * @return bool
 */
if (!function_exists('storage_exists')) {
    function storage_exists(string $path) {
        return file_exists(storage($path));
    }
}

/**
 * file_url function
 *
 * Build a public URL for a stored file.
 *
 * @param string $path Relative path inside storage
 * @return string
 */
if (!function_exists('file_url')) {
    function file_url(string $path) {
        $prefix = trim(config('files.url_prefix') ?? 'storage/files', '/');
        return config('app.url') . '/' . $prefix . '/' . trim($path, '/');
    }
}

/**
 * get_file function
 *
 * Get the contents of a stored file.
 *
 * @param string $path Relative path inside storage
 * @return string|false File contents or false when missing
 */
if (!function_exists('get_file')) {
    function get_file(string $path) {
        $absolute = storage($path);
        if (!is_file($absolute)) {
            return false;
        }
        return file_get_contents($absolute);
    }
}

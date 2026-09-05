<?php

if (!function_exists('trans')) {
    function trans(string $key = null, $default = null) {
        $path = config('lang.path');
        $locale = get_session('lang') ?? config('lang.default');
        $supported_languages = config('lang.supports') ?? [];
        $fallback = config('lang.fallback') ?? null;

        $segments = explode('.', $key);
        $file = $segments[0];
        $translation_key = $segments[1] ?? null;

        if (in_array($locale, $supported_languages)) {
            $language_file = $path . '/' . $locale . '/' . $file . '.php';
            if (file_exists($language_file)) {
                $translations = include $language_file;
                return $translations[$translation_key] ?? $default;
            }
        }

        if ($fallback && $fallback !== $locale && in_array($fallback, $supported_languages)) {
            $language_file = $path . '/' . $fallback . '/' . $file . '.php';
            if (file_exists($language_file)) {
                $translations = include $language_file;
                return $translations[$translation_key] ?? $default;
            }
        }

        return $default;
    }
}
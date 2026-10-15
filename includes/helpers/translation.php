<?php

if (!function_exists('trans')) {
    function trans(string $key = null, $replace = [], $default = null) {
        // Backward compat: trans('key', 'default') or trans('key', ['attr' => 'x'])
        if (!is_array($replace)) {
            $default = $replace;
            $replace = [];
        }
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
                $message = $translations[$translation_key] ?? $default;
                return replace_placeholders($message, $replace);
            }
        }

        if ($fallback && $fallback !== $locale && in_array($fallback, $supported_languages)) {
            $language_file = $path . '/' . $fallback . '/' . $file . '.php';
            if (file_exists($language_file)) {
                $translations = include $language_file;
                $message = $translations[$translation_key] ?? $default;
                return replace_placeholders($message, $replace);
            }
        }

        return replace_placeholders($default, $replace);
    }
}

if (!function_exists('replace_placeholders')) {
    function replace_placeholders($message, array $replace = []) {
        if (!is_string($message) || empty($replace)) {
            return $message;
        }
        foreach ($replace as $placeholder => $value) {
            $message = str_replace(':' . $placeholder, (string) $value, $message);
        }
        return $message;
    }
}
<?php

$validations = [];

if (!function_exists('request')) {
    function request(string $key, $default = null) {
        return $_REQUEST[$key] ?? $default;
    }
}

if (!function_exists('validate')) {
    function validate(string $attribute, $value = null, $rules = []) {
        // Use passed $value, fallback to request data if null
        $value = $value ?? request($attribute);
        global $validations;
        $passed = true;

        // Human-readable label from keywords (e.g. keywords.name), fallback to raw attribute
        $label = trans('keywords.' . $attribute, [], $attribute);

        // Detect $_FILES-style array
        $isFile = is_array($value) && array_key_exists('tmp_name', $value);
        $fileOk = $isFile && ($value['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK;

        if (in_array('email', $rules) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $validations[$attribute] = trans('validation.email', ['attribute' => $label]);
            $passed = false;
        }

        if (in_array('required', $rules)) {
            $empty = $isFile ? !$fileOk : (empty($value) && $value !== '0');
            if ($empty) {
                $validations[$attribute] = trans('validation.required', ['attribute' => $label]);
                $passed = false;
            }
        }

        if (in_array('numeric', $rules) && !is_numeric($value)) {
            $validations[$attribute] = trans('validation.numeric', ['attribute' => $label]);
            $passed = false;
        }

        if (in_array('string', $rules) && !$isFile && !is_string($value)) {
            $validations[$attribute] = trans('validation.string', ['attribute' => $label]);
            $passed = false;
        }

        if (in_array('boolean', $rules) && filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null) {
            $validations[$attribute] = trans('validation.boolean', ['attribute' => $label]);
            $passed = false;
        }

        if (in_array('max', $rules) && is_numeric($value) && $value > $rules['max']) {
            $validations[$attribute] = trans('validation.max', ['attribute' => $label, 'max' => $rules['max']]);
            $passed = false;
        }

        if (in_array('min', $rules) && is_numeric($value) && $value < $rules['min']) {
            $validations[$attribute] = trans('validation.min', ['attribute' => $label, 'min' => $rules['min']]);
            $passed = false;
        }

        if (in_array('between', $rules) && is_numeric($value) && ($value < $rules['between']['min'] || $value > $rules['between']['max'])) {
            $validations[$attribute] = trans('validation.between', ['attribute' => $label, 'min' => $rules['between']['min'], 'max' => $rules['between']['max']]);
            $passed = false;
        }

        if (in_array('file', $rules) && !$fileOk) {
            $validations[$attribute] = trans('validation.file', ['attribute' => $label]);
            $passed = false;
        }

        if (in_array('image', $rules) && $fileOk) {
            $ext = strtolower(pathinfo($value['name'] ?? '', PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $validations[$attribute] = trans('validation.image', ['attribute' => $label]);
                $passed = false;
            }
        }

        // Support 'mimes:jpg,png,pdf' string rule or ['mimes' => [...]] / $rules['mimes']
        $mimes = $rules['mimes'] ?? null;
        foreach ((array) $rules as $rule) {
            if (is_string($rule) && str_starts_with($rule, 'mimes:')) {
                $mimes = explode(',', substr($rule, 6));
            }
        }
        if ($mimes && $fileOk) {
            $mimes = array_map('strtolower', (array) $mimes);
            $ext = strtolower(pathinfo($value['name'] ?? '', PATHINFO_EXTENSION));
            if (!in_array($ext, $mimes)) {
                $validations[$attribute] = trans('validation.mimes', ['attribute' => $label, 'mimes' => implode(', ', $mimes)]);
                $passed = false;
            }
        }

        session()->set('validations', $validations);

        return $passed;
    }
}

if (!function_exists('validation_error')) {
    function validation_error(string $attribute, $default = null) {
        $errors = get_session('validations') ?? [];
        return $errors[$attribute] ?? $default;
    }
}
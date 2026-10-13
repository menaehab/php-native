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

        if (in_array('email', $rules) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $validations[$attribute] = trans('validation.email', ['attribute' => $attribute]);
            $passed = false;
        }

        if (in_array('required', $rules) && empty($value)) {
            $validations[$attribute] = trans('validation.required', ['attribute' => $attribute]);
            $passed = false;
        }

        if (in_array('numeric', $rules) && !is_numeric($value)) {
            $validations[$attribute] = trans('validation.numeric', ['attribute' => $attribute]);
            $passed = false;
        }

        if (in_array('string', $rules) && !is_string($value)) {
            $validations[$attribute] = trans('validation.string', ['attribute' => $attribute]);
            $passed = false;
        }

        if (in_array('boolean', $rules) && filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null) {
            $validations[$attribute] = trans('validation.boolean', ['attribute' => $attribute]);
            $passed = false;
        }

        return $passed;
    }
}
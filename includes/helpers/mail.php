<?php

if (!function_exists('send_mail')) {
    function send_mail($emails, $subject, $message) {
        if (is_array($emails)) {
            $emails = implode(',', $emails);
        }
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . config('mail.address') . "\r\n";
        return mail($emails, $subject, $message, $headers);
    }
}


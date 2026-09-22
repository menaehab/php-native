<?php
/**
 * @param string $value
 * @return string
 * 
 * @desc encrypt data
 */
if (!function_exists('encrypt')) {
    function encrypt($value)
    {
        $cipher = 'AES-128-CBC';
        $key = '1234567890123456';

        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);

        $cipherTextRaw = openssl_encrypt($value,$cipher,$key,OPENSSL_RAW_DATA,$iv);
        $hmac = hash_hmac('sha256',$cipherTextRaw,$key,true);

        return base64_encode($iv . $hmac . $cipherTextRaw);
    }
}
/**
 * @param string $encrypted
 * @return string
 * 
 * @desc decrypt data
 */
if (!function_exists('decrypt')) {
    function decrypt($encrypted)
    {
        $cipher = 'AES-128-CBC';
        $key = '1234567890123456';

        $ivlen = openssl_cipher_iv_length($cipher);
        $convert = base64_decode($encrypted, true);

        if ($convert === false) {
            return false;
        }

        $iv = substr($convert, 0, $ivlen);
        $hmac = substr($convert, $ivlen, 32);
        $cipherTextRaw = substr($convert, $ivlen + 32);

        $expectedHmac = hash_hmac('sha256',$cipherTextRaw,$key,true);

        if (!hash_equals($hmac, $expectedHmac)) {
            return false;
        }

        return openssl_decrypt($cipherTextRaw,$cipher,$key,OPENSSL_RAW_DATA,$iv);
    }
}
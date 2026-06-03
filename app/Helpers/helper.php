<?php 

function _log(...$objs){
    $bt = debug_backtrace();
    $caller = array_shift($bt);
    error_log('[Log - File:'.$caller['file'].' Line:'.$caller['line'].']');
    foreach($objs as $obj){
        if(is_bool($obj))
            $obj = ($obj)? 'true' : 'false';
        error_log(print_r($obj , true));
    }
}

function _encrypt(string $data): string
{
    $ivLength = openssl_cipher_iv_length('AES-256-CBC');
    $iv = random_bytes($ivLength); // Generate a random initialization vector
    $encrypted = openssl_encrypt($data, 'AES-256-CBC', env('APP_KEY'), OPENSSL_RAW_DATA, $iv);
    if ($encrypted === false) {
        throw new Exception("Encryption failed");
    }
    // Concatenate IV and encrypted data, and encode as URL-safe Base64
    $encryptedData = base64_encode($iv . $encrypted);
    return rtrim(strtr($encryptedData, '+/', '-_'), '=');
}

function _decrypt(string $encryptedData): string
{
    $encryptedData = str_pad(strtr($encryptedData, '-_', '+/'), strlen($encryptedData) % 4, '=', STR_PAD_RIGHT);
    $decoded = base64_decode($encryptedData, true);
    if ($decoded === false) {
        //throw new Exception("Decoding failed");
    }
    $ivLength = openssl_cipher_iv_length('AES-256-CBC');
    $iv = substr($decoded, 0, $ivLength); // Extract the IV
    $ciphertext = substr($decoded, $ivLength); // Extract the ciphertext
    $decrypted = openssl_decrypt($ciphertext, 'AES-256-CBC', env('APP_KEY'), OPENSSL_RAW_DATA, $iv);
    if ($decrypted === false) {
        throw new Exception("Decryption failed");
    }
    return $decrypted;
}

?>
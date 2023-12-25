<?php
function generateRandomString($length = 32) {
    // Generate random binary data
    $randomBinary = openssl_random_pseudo_bytes($length);

    // Convert binary to hexadecimal
    $randomHex = bin2hex($randomBinary);

    return $randomHex;
}

// Usage
$randomString = generateRandomString();
echo $randomString;
?>

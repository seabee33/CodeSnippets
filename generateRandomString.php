<?php
$randomString = bin2hex(openssl_random_pseudo_bytes(32));
echo $randomString;
?>


// openssl... is random binary garbage, looks like this (�5r�V�$L� /E1̨��Q ���C�^�)
// Bin 2 Hex turns binary garbage to a readable string of random data like this (7234a94a6700f12d4a98109b3ca8a322619a4d435cf7eb6b4a7f5899f41a728d)

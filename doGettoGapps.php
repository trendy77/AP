<?php
//apps script - overview doGet address:
$url ='https://script.google.com/macros/s/AKfycbxrAvQlbrJTj1xUAV3IZf-ko3ZQEVIM29YMv3G9pekm2OjbzDI/exec';

$ch = curl_init($url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, false); 
//curl_setopt(
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$status = curl_getinfo($ch);
curl_close($ch);

echo '$response';
echo '$status';
?> 
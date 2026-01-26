<?php
$key = pack('H*', "2020*sistemakv*DESARROLLO-ORT_LP");
$ciphertext_base64 = $_POST['texto'];

$ciphertext_dec = base64_decode($ciphertext_base64);
    
$iv_dec = substr($ciphertext_dec, 0, $iv_size);
    
$ciphertext_dec = substr($ciphertext_dec, $iv_size);

$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
    
//echo  $plaintext_dec . "<br/>";

header('Content-type:text/xml');
$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8' standalone='yes'?><Encriptacion></Encriptacion>");

$titulo = $xml->addChild('Resultado');
$name = $titulo->addChild('texto',$plaintext_dec);

print($xml->asXML());
?>
<?php
$key = pack('H*', "2020*sistemakv*DESARROLLO-ORT_LP");
$plaintext = $_POST['texto'];

$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);

$ciphertext = $iv . $ciphertext;
    
$ciphertext_base64 = base64_encode($ciphertext);

//echo $ciphertext_base64 . "<br/>";

header('Content-type:text/xml');
$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8' standalone='yes'?><Encriptacion></Encriptacion>");

$titulo = $xml->addChild('Resultado');
$name = $titulo->addChild('texto',$ciphertext_base64);

print($xml->asXML());
?>
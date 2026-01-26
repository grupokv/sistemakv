<?php
class Seguridad
{
	public function encrypt($plaintext){

		$key = pack('H*', "2020*sistemakv*DESARROLLO-ORT_LP");
		
		$iv = mcrypt_create_iv(
			mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC),
			MCRYPT_DEV_URANDOM
		);
		
		$encrypted = base64_encode(
			$iv .
			mcrypt_encrypt(
				MCRYPT_RIJNDAEL_256,
				hash('sha256', $key, true),
				$plaintext,
				MCRYPT_MODE_CBC,
				$iv
			)
		);
		return $encrypted;

	} 

	public function decrypt($text){
		
		$key = pack('H*', "2020*sistemakv*DESARROLLO-ORT_LP");
		
		$data = base64_decode($text);
		$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
		
		$decrypted = rtrim(
			mcrypt_decrypt(
				MCRYPT_RIJNDAEL_256,
				hash('sha256', $key, true),
				substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)),
				MCRYPT_MODE_CBC,
				$iv
			)
		);
		return $decrypted;
	}

}
?>
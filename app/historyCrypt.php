<?php
	namespace App;
	class historyCrypt{
     public static function encrypt($string){
     	return base64_encode(openssl_encrypt ($string, 'aes-128-cbc', '1234567812345678', true, "1234567812345678"));
	 }
	 public static function decrypt($string){
     	return openssl_decrypt (base64_decode($string), 'aes-128-cbc', '1234567812345678', true, "1234567812345678");
	 }
 } 

?>

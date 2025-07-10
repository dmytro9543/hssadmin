<?php
	//This is a symmetric key that will be used in 3-DES block cipher.
	$key = "this is a secret";
    function encrypt($data, $key){
                return   mcrypt_encrypt(
                        MCRYPT_RIJNDAEL_128,
                        $key,
                        $data,
                        MCRYPT_MODE_CBC,
                        "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"
                );
        }
	 function decrypt($data, $key){
	     return mcrypt_decrypt(
	                     MCRYPT_RIJNDAEL_128,
	                     $key,
	                     $data,
	                     MCRYPT_MODE_CBC,
	                     "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"
	             );
	 }
?>

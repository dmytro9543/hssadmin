<?php
	namespace App;
	class MyCrypt{
		protected $key = "this is a secret";
	    function my_Encrypt($data, $key){
	                return   mcrypt_encrypt(
	                        MCRYPT_RIJNDAEL_128,
	                        $key,
	                        $data,
	                        MCRYPT_MODE_CBC,
	                        "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"
	                );
	        }
		 function my_Decrypt($data, $key){
		     return mcrypt_decrypt(
		                     MCRYPT_RIJNDAEL_128,
		                     $key,
		                     $data,
		                     MCRYPT_MODE_CBC,
		                     "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"
		             );
		 }
		}

?>

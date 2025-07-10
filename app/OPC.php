<?php
	namespace App;
	class OPC {
		var $m_opc;
		var $roundKeys = array();
		var $state = array();
		var $S = array(
			  99, 124, 119, 123, 242, 107, 111, 197, 48, 1, 103, 43, 254, 215, 171, 118,
			  202, 130, 201, 125, 250, 89, 71, 240, 173, 212, 162, 175, 156, 164, 114, 192,
			  183, 253, 147, 38, 54, 63, 247, 204, 52, 165, 229, 241, 113, 216, 49, 21,
			  4, 199, 35, 195, 24, 150, 5, 154, 7, 18, 128, 226, 235, 39, 178, 117,
			  9, 131, 44, 26, 27, 110, 90, 160, 82, 59, 214, 179, 41, 227, 47, 132,
			  83, 209, 0, 237, 32, 252, 177, 91, 106, 203, 190, 57, 74, 76, 88, 207,
			  208, 239, 170, 251, 67, 77, 51, 133, 69, 249, 2, 127, 80, 60, 159, 168,
			  81, 163, 64, 143, 146, 157, 56, 245, 188, 182, 218, 33, 16, 255, 243, 210,
			  205, 12, 19, 236, 95, 151, 68, 23, 196, 167, 126, 61, 100, 93, 25, 115,
			  96, 129, 79, 220, 34, 42, 144, 136, 70, 238, 184, 20, 222, 94, 11, 219,
			  224, 50, 58, 10, 73, 6, 36, 92, 194, 211, 172, 98, 145, 149, 228, 121,
			  231, 200, 55, 109, 141, 213, 78, 169, 108, 86, 244, 234, 101, 122, 174, 8,
			  186, 120, 37, 46, 28, 166, 180, 198, 232, 221, 116, 31, 75, 189, 139, 138,
			  112, 62, 181, 102, 72, 3, 246, 14, 97, 53, 87, 185, 134, 193, 29, 158,
			  225, 248, 152, 17, 105, 217, 142, 148, 155, 30, 135, 233, 206, 85, 40, 223,
			  140, 161, 137, 13, 191, 230, 66, 104, 65, 153, 45, 15, 176, 84, 187, 22
		);
		var $Xtime = array(
			  0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30,
			  32, 34, 36, 38, 40, 42, 44, 46, 48, 50, 52, 54, 56, 58, 60, 62,
			  64, 66, 68, 70, 72, 74, 76, 78, 80, 82, 84, 86, 88, 90, 92, 94,
			  96, 98, 100, 102, 104, 106, 108, 110, 112, 114, 116, 118, 120, 122, 124, 126,
			  128, 130, 132, 134, 136, 138, 140, 142, 144, 146, 148, 150, 152, 154, 156, 158,
			  160, 162, 164, 166, 168, 170, 172, 174, 176, 178, 180, 182, 184, 186, 188, 190,
			  192, 194, 196, 198, 200, 202, 204, 206, 208, 210, 212, 214, 216, 218, 220, 222,
			  224, 226, 228, 230, 232, 234, 236, 238, 240, 242, 244, 246, 248, 250, 252, 254,
			  27, 25, 31, 29, 19, 17, 23, 21, 11, 9, 15, 13, 3, 1, 7, 5,
			  59, 57, 63, 61, 51, 49, 55, 53, 43, 41, 47, 45, 35, 33, 39, 37,
			  91, 89, 95, 93, 83, 81, 87, 85, 75, 73, 79, 77, 67, 65, 71, 69,
			  123, 121, 127, 125, 115, 113, 119, 117, 107, 105, 111, 109, 99, 97, 103, 101,
			  155, 153, 159, 157, 147, 145, 151, 149, 139, 137, 143, 141, 131, 129, 135, 133,
			  187, 185, 191, 189, 179, 177, 183, 181, 171, 169, 175, 173, 163, 161, 167, 165,
			  219, 217, 223, 221, 211, 209, 215, 213, 203, 201, 207, 205, 195, 193, 199, 197,
			  251, 249, 255, 253, 243, 241, 247, 245, 235, 233, 239, 237, 227, 225, 231, 229
		);
		function __construct($ki, $op){
			$this->m_opc = $this->createOPC($ki, $op);
		}

		function createOPC($ki, $op){
			$hex = "";
			$this->RijndaelKeySchedule($ki);
			$opP = $this->blocking_Per_Byte($op);
			$opcP = $this->RijndaelEncrypt($op);
			for ($i = 0; $i < 16; $i++)
      			$opcP[$i] ^= $opP[$i];
      		for ($i = 0; $i < 16; $i++) {
      			$hex .= sprintf("%02x", $opcP[$i]);
      		}
			return $hex;
		}

		function getOPC(){
			return $this->m_opc;
		}

		function KeyAdd($round) {
		  for ($i = 0; $i < 4; $i++)
		    for ($j = 0; $j < 4; $j++)
		      $this->state[$i][$j] ^= $this->roundKeys[$round][$i][$j];
		}

		function ByteSub() {
			for ($i = 0; $i < 4; $i++)
			    for ($j = 0; $j < 4; $j++)
			      $this->state[$i][$j] = $this->S[$this->state[$i][$j]];
		}

		function ShiftRow() {
		  $temp = $this->state[1][0];
		  $this->state[1][0] = $this->state[1][1];
		  $this->state[1][1] = $this->state[1][2];
		  $this->state[1][2] = $this->state[1][3];
		  $this->state[1][3] = $temp;
		  /*
		   * left rotate row 2 by 2
		   */
		  $temp = $this->state[2][0];
		  $this->state[2][0] = $this->state[2][2];
		  $this->state[2][2] = $temp;
		  $temp = $this->state[2][1];
		  $this->state[2][1] = $this->state[2][3];
		  $this->state[2][3] = $temp;
		  /*
		   * left rotate row 3 by 3
		   */
		  $temp = $this->state[3][0];
  		  //array_shift($state[3]);

		  $this->state[3][0] = $this->state[3][3];
		  $this->state[3][3] = $this->state[3][2];
		  $this->state[3][2] = $this->state[3][1];
		  $this->state[3][1] = $temp;
		}

		function MixColumn() {
		  for ($i = 0; $i < 4; $i++) {
		    $temp = $this->state[0][$i] ^ $this->state[1][$i] ^ $this->state[2][$i] ^ $this->state[3][$i];
		    $tmp0 = $this->state[0][$i];
		    /*
		     * Xtime array does multiply by x in GF2^8
		     */
		    $tmp = $this->Xtime[$this->state[0][$i] ^ $this->state[1][$i]];
		    $this->state[0][$i] ^= $temp ^ $tmp;
		    $tmp = $this->Xtime[$this->state[1][$i] ^ $this->state[2][$i]];
		    $this->state[1][$i] ^= $temp ^ $tmp;
		    $tmp = $this->Xtime[$this->state[2][$i] ^ $this->state[3][$i]];
		    $this->state[2][$i] ^= $temp ^ $tmp;
		    $tmp = $this->Xtime[$this->state[3][$i] ^ $tmp0];
		    $this->state[3][$i] ^= $temp ^ $tmp;
		  }
		}

		function RijndaelEncrypt($op) {
			$input = $this->blocking_Per_Byte($op);
			for ($i = 0; $i < 16; $i++)
      			$this->state[$i & 0x3][$i >> 2] = $input[$i];
		    $this->KeyAdd(0);
		    for ($r = 1; $r <= 9; $r++) {
		      $this->ByteSub();
		      $this->ShiftRow();
		      $this->MixColumn();
		      $this->KeyAdd ($r);
		    }
		    /*
		     * final round
		     */
		    $this->ByteSub();
		    $this->ShiftRow();
		    $this->KeyAdd (10);

		    /*
		     * produce output byte string from state array
		     */
		    $output = array();

		    for ($i = 0; $i < 16; $i++)
		      array_push($output, $this->state[$i & 0x3][$i >> 2]);
		    

		    return $output;
		}

		function RijndaelKeySchedule($ki) {
			$key = $this->blocking_Per_Byte($ki);
			for($i=0; $i<16; $i++)
				$this->roundKeys[0][$i&0x03][$i>>2] = $key[$i];
			$roundConst = 1;
		    for($i = 1; $i < 11; $i++) {
		      $this->roundKeys[$i][0][0] = $this->S[$this->roundKeys[$i - 1][1][3]] ^ $this->roundKeys[$i - 1][0][0] ^ $roundConst;
		      $this->roundKeys[$i][1][0] = $this->S[$this->roundKeys[$i - 1][2][3]] ^ $this->roundKeys[$i - 1][1][0];
		      $this->roundKeys[$i][2][0] = $this->S[$this->roundKeys[$i - 1][3][3]] ^ $this->roundKeys[$i - 1][2][0];
		      $this->roundKeys[$i][3][0] = $this->S[$this->roundKeys[$i - 1][0][3]] ^ $this->roundKeys[$i - 1][3][0];

		      for ($j = 0; $j < 4; $j++) {
		        $this->roundKeys[$i][$j][1] = $this->roundKeys[$i - 1][$j][1] ^ $this->roundKeys[$i][$j][0];
		        $this->roundKeys[$i][$j][2] = $this->roundKeys[$i - 1][$j][2] ^ $this->roundKeys[$i][$j][1];
		        $this->roundKeys[$i][$j][3] = $this->roundKeys[$i - 1][$j][3] ^ $this->roundKeys[$i][$j][2];
		      }
		      
		      $roundConst = $this->Xtime[$roundConst];
		    }
		}

		function blocking_Per_Byte($str){
			$blocking = array();
			for($i=0; $i<strlen($str); $i+=2) {
				$bin = $this->convert_From_Character_To_Binary($str[$i]).$this->convert_From_Character_To_Binary($str[$i+1]);
				array_push($blocking, bindec($bin));
				$bin = "";
			}
			return $blocking;
		}

		public function convert_From_Character_To_Binary($c){
			$value = ord($c)-0x30;
			if($c == 'a' || $c == 'A') $value = 10;
			if($c == 'b' || $c == 'B') $value = 11;
			if($c == 'c' || $c == 'C') $value = 12;
			if($c == 'd' || $c == 'D') $value = 13;
			if($c == 'e' || $c == 'E') $value = 14;
			if($c == 'f' || $c == 'F') $value = 15;
			$bin = "";
			switch($value){
				case 0:
					$bin .= "0000";
					break;
				case 1:
					$bin .= "0001";
					break;
				case 2:
					$bin .= "0010";
					break;
				case 3:
					$bin .= "0011";
					break;
				case 4:
					$bin .= "0100";
					break;
				case 5:
					$bin .= "0101";
					break;
				case 6:
					$bin .= "0110";
					break;
				case 7:
					$bin .= "0111";
					break;
				case 8:
					$bin .= "1000";
					break;
				case 9:
					$bin .= "1001";
					break;
				case 10:
					$bin .= "1010";
					break;
				case 11:
					$bin .= "1011";
					break;
				case 12:
					$bin .= "1100";
					break;
				case 13:
					$bin .= "1101";
					break;
				case 14:
					$bin .= "1110";
					break;
				case 15:
					$bin .= "1111";
					break;
			}
			return $bin;
		}

	}
?>
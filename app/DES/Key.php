<?php
	namespace App\DES;
	class Key{		
		var $PC_1 = array(
	        	57, 49, 41, 33, 25, 17, 9,
	        	1, 58, 50, 42, 34, 26, 18,
		        10, 2, 59, 51, 43, 35, 27,
		        19, 11, 3, 60, 52, 44, 36,
		        63, 55, 47, 39, 31, 23, 15,
		        7, 62, 54, 46, 38, 30, 22,
		        14, 6, 61, 53, 45, 37, 29,
		        21, 13, 5, 28, 20, 12, 4
    		);
    		
		var $PC_2 = array(
			14, 17, 11, 24, 1, 5,
	        3, 28, 15, 6, 21, 10,
	        23, 19, 12, 4, 26, 8,
	        16, 7, 27, 20, 13, 2,
	        41, 52, 31, 37, 47, 55,
	        30, 40, 51, 45, 33, 48,
	        44, 49, 39, 56, 34, 53,
	        46, 42, 50, 36, 29, 32
		);

		var $m_kArray = array();
		function __construct($keyWord){
			$this->setKeyArray($keyWord);
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

		public function convert_From_KeyWord_To_64BitBinary($hex){
			$binary = "";
			for($i=0; $i<strlen($hex); $i++)
				$binary .= $this->convert_From_Character_To_Binary($hex[$i]);
			return $binary;
		}

		public function LCS($Ci_1, $Di_1, $i){
			$Ci = "";$Di = "";
			$st = 2;
			$en = 28;
			if($i == 1 || $i == 2 || $i == 9 || $i == 16)
				$st = 1;
			for($j=$st; $j<$en; $j++){
				$Ci .= $Ci_1[$j];
				$Di .= $Di_1[$j];
			}
			$k = 0;
			while($k < $st){
				$Ci .= $Ci_1[$k];
				$Di .= $Di_1[$k++];
			}
			return $Ci.$Di;
		}

		public function setKeyArray($keyword){
			$bin_64Bit = $this->convert_From_KeyWord_To_64BitBinary($keyword);
			$bin_56Bit = "";
			for($i=0; $i<56; $i++)
				$bin_56Bit .= $bin_64Bit[$this->PC_1[$i]-1];
			$C = "";
			$D = "";
			for($i=0; $i<56; $i++){
				if($i <28)
					$C .= $bin_56Bit[$i];
				else
					$D .= $bin_56Bit[$i];
			}
			
			for($i=1; $i<=16; $i++){
				$CiDi = $this->LCS($C, $D, $i);
				$C = "";$D = "";
				for($k=0; $k<56; $k++) {
					if($k <28)
						$C .= $CiDi[$k];
					else
						$D .= $CiDi[$k];
				}
				$ki = "";
				for($j=0; $j<48; $j++)
					$ki .= $CiDi[$this->PC_2[$j]-1];
				array_push($this->m_kArray, $ki);
			}
		}
		public function getKi($index)
		{
			return $this->m_kArray[$index-1];
		}
	}

?>

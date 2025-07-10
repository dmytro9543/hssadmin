<?php
	namespace App\DES;
	use App\DES\Key;
	class DES{
		// var $text;
		// var $keyword;
		var $ipTransposition= array(
							   58, 50, 42, 34, 26, 18, 10, 2,
                               60, 52, 44, 36, 28, 20, 12, 4,
                               62, 54, 46, 38, 30, 22, 14, 6,
                               64, 56, 48, 40, 32, 24, 16, 8,
                               57, 49, 41, 33, 25, 17, 9, 1,
                               59, 51, 43, 35, 27, 19, 11, 3,
                               61, 53, 45, 37, 29, 21, 13, 5,
                               63, 55, 47, 39, 31, 23, 15, 7);
        var $E = array(
	        32, 1, 2, 3, 4, 5,
	        4, 5, 6, 7, 8, 9,
	        8, 9, 10, 11, 12, 13,
	        12, 13, 14, 15, 16, 17,
	        16, 17, 18, 19, 20, 21,
	        20, 21, 22, 23, 24, 25,
	        24, 25, 26, 27, 28, 29,
	        28, 29, 30, 31, 32, 1
    	);

    	var $S = array(
        array(
	        array(14, 4, 13, 1, 2, 15, 11, 8, 3, 10, 6, 12, 5, 9, 0, 7),
	        array(0 , 15, 7, 4, 14, 2, 13, 1, 10, 6, 12, 11, 9, 5, 3, 8),
	        array(4, 1, 14, 8, 13, 6, 2, 11, 15, 12, 9, 7, 3, 10, 5, 0),
	        array(15, 12, 8, 2, 4, 9, 1, 7, 5, 11, 3, 14, 10, 0, 6, 13)
	        ),
        array(
	        array(15, 1, 8, 14, 6, 11, 3, 4, 9, 7, 2, 13, 12, 0, 5, 10),
	        array(3, 13, 4, 7, 15, 2, 8, 14, 12, 0, 1, 10, 6, 9, 11, 5),
	        array(0, 14, 7, 11, 10, 4, 13, 1, 5, 8, 12, 6, 9, 3, 2, 15),
	        array(13, 8, 10, 1, 3, 15, 4, 2, 11, 6, 7, 12, 0, 5, 14, 9)
        	),
        array(
	        array(10, 0, 9, 14, 6, 3, 15, 5, 1, 13, 12, 7, 11, 4, 2, 8),
	        array(13, 7, 0, 9, 3, 4, 6, 10, 2, 8, 5, 14, 12, 11, 15, 1),
	        array(13, 6, 4, 9, 8, 15, 3, 0, 11, 1, 2, 12, 5, 10, 14, 7),
	        array(1, 10, 13, 0, 6, 9, 8, 7, 4, 15, 14, 3, 11, 5, 2, 12)
        	),
        array(
	        array(7, 13, 14, 13, 0, 6, 9, 10, 1, 2, 8, 5, 11, 12, 4, 15),
	        array(13, 8, 11, 5, 6, 15, 0, 3, 4, 7, 2, 12, 1, 10, 14, 9),
	        array(10, 6, 9, 0, 12, 11, 7, 13, 15, 1, 3, 14, 5, 2, 8, 4),
	        array(3, 15, 0, 6, 10, 1, 13, 8, 9, 4, 5, 11, 12, 7, 2, 14)
        	),
        array(
	        array(2, 12, 4, 1, 7, 10, 11, 6, 8, 5, 3, 15, 13, 0, 14, 9),
	        array(14, 11, 2, 12, 4, 7, 13, 1, 5, 0, 15, 10, 3, 9, 8, 6),
	        array(4, 2, 1, 11, 10, 13, 7, 8, 15, 9, 12, 5, 6, 3, 0, 14),
	        array(11, 8, 12, 7, 1, 14, 2, 13, 6, 15, 0, 9, 10, 4, 5, 3)
        	),
        array(
	        array(4, 11, 2, 14, 15, 0, 8, 13, 3, 12, 9, 7, 5, 10, 6, 1),
	        array(13, 0, 11, 7, 4, 9, 1, 10, 14, 3, 5, 12, 2, 15, 8, 6),
	        array(1, 4, 11, 13, 12, 3, 7, 14, 10, 15, 6, 8, 0, 5, 9, 12),
	        array(6, 11, 13, 8, 1, 4, 10, 7, 9, 5, 0, 15, 14, 2, 13, 12)
	        ),
        array(
	        array(12, 1, 10, 15, 9, 2, 6, 8, 0, 13, 3, 4, 14, 7, 5, 11),
	        array(10, 15, 4, 2, 7, 12, 9, 5, 6, 1, 13, 14, 0, 11, 3, 8),
	        array(9, 14, 15, 5, 2, 8, 12, 3, 7, 0, 4, 10, 1, 13, 11, 6),
	        array(4, 3, 2, 12, 9, 5, 15, 10, 11, 14, 1, 7, 6, 0, 8, 13)
        ),
        array(
	        array(13, 2, 8, 4, 6, 15, 11, 1, 10, 9, 3, 14, 5, 0, 12, 7),
	        array(1, 15, 13, 8, 10, 3, 7, 4, 12, 5, 6, 11, 0, 14, 9, 2),
	        array(7, 11, 4, 1, 9, 12, 14, 2, 0, 6, 10, 13, 15, 3, 5, 8),
	        array(2, 1, 14, 7, 4, 10, 8, 13, 15, 12, 9, 0, 3, 5, 6, 11)
	        )
    	);

    	var $P = array(
	        16, 7, 20, 21,
	        29, 12, 28, 17,
	        1, 15, 23, 26,
	        5, 18, 31, 10,
	        2, 8, 24, 14,
	        32, 27, 3, 9,
	        19, 13, 30, 6,
	        22, 11, 4, 25
    	);

    	var $InverseIp = array(
	        40, 8, 48, 16, 56, 24, 64, 32,
	        39, 7, 47, 15, 55, 23, 63, 31,
	        38, 6, 46, 14, 54, 22, 62, 30,
	        37, 5, 45, 13, 53, 21, 61, 29,
	        36, 4, 44, 12, 52, 20, 60, 28,
	        35, 3, 43, 11, 51, 19, 59, 27,
	        34, 2, 42, 10, 50, 18, 58, 26,
	        33, 1, 41, 9, 49, 17, 57, 25
    	);

		function __construct(/*$text, $keyword*/){
			// $this->$text = $text;
			// $this->$keyword = $keyword;
		}

		public function decrypt($text, $keyword){
			$binArray = $this->BlocingPer64Bit($text);
			$bin_result = "";
			$hex = "";
			$key = new Key($keyword);
			for($cnt=0; $cnt<count($binArray); $cnt++){
				$bin = $binArray[$cnt];
				$L16R16 = "";

				for($i=0; $i<64; $i++){
					for($j=0; $j<64; $j++){
						if($this->InverseIp[$j] == $i+1){
							$L16R16 .= $bin[$j];
							break;
						}
					}
				}
				$L = "";
				$R = "";
				for($i=0; $i<64; $i++){
					if($i<32)
						$L .= $L16R16[$i];
					else
						$R .= $L16R16[$i];
				}
				for($i=16; $i>=1; $i--){
					$tmp = $this->iStepEncrypt($L, $R, $key->getKi($i));
					$L = "";
					$R = "";
					for($j=0; $j<64; $j++){
						if($j<32)
							$L .= $tmp[$j];
						else
							$R .= $tmp[$j];
					}
				}
				$L0R0 = $L.$R;
				$data = $this->initialTransition($L0R0);
				$bin_result .= $data;
				$data = "";
				}
				$bin = "";
				for($i=0; $i<strlen($bin_result); $i++){
					$bin .= $bin_result[$i];
					if(($i+1)%4 == 0){
						if($bin == "0000") $hex.="0";
				        if($bin == "0001") $hex.="1";
				        if($bin == "0010") $hex.="2";
				        if($bin == "0011") $hex.="3";
				        if($bin == "0100") $hex.="4";
				        if($bin == "0101") $hex.="5";
				        if($bin == "0110") $hex.="6";
				        if($bin == "0111") $hex.="7";
				        if($bin == "1000") $hex.="8";
				        if($bin == "1001") $hex.="9";
				        if($bin == "1010") $hex.="a";
				        if($bin == "1011") $hex.="b";
				        if($bin == "1100") $hex.="c";
				        if($bin == "1101") $hex.="d";
				        if($bin == "1110") $hex.="e";
				        if($bin == "1111") $hex.="f";
						$bin = "";
					}
					
				}

				return $hex;
			}
		public function initialTransition($bin_64Bit){
			$array = "";
			for($i=0; $i<64; $i++){
				for($j=0; $j<64; $j++){
					if($this->ipTransposition[$j] == $i+1){
						$array .= $bin_64Bit[$j];
						break;
					}
				}
			}
			return $array;
		}

		public function iStepEncrypt($Li, $Ri, $key_i){
			$Ri_1 = $Li;
			$Li_1 = $this->exclusiveOr($Ri, $this->f($Ri_1, $key_i));
			return $Li_1.$Ri_1;
		}

		public function exclusiveOr($A, $B){
			$exclusiveOrResult = "";
			for($i=0; $i<strlen($A); $i++){
				if($A[$i] != $B[$i])
					$exclusiveOrResult .="1";
				else
					$exclusiveOrResult .= "0";
			}
			return $exclusiveOrResult;
		}

		public function f($Ri_1, $key_i){
			$E_48Bit = "";
			for($i=0; $i<48; $i++)
				$E_48Bit .= $Ri_1[$this->E[$i]-1];
			$A_48Bit = $this->exclusiveOr($E_48Bit, $key_i);
			$Blocking_Per_6Bit = array();
			$tmp = "";
			for($i=0; $i<48; $i++){
				$tmp .= $A_48Bit[$i];
				if(($i+1)%6 == 0){
					array_push($Blocking_Per_6Bit, $tmp);
					$tmp = "";
				}
			}
			$k = 0;
			$bin_32Bit = "";
			
			foreach ($Blocking_Per_6Bit as $key=> $bin_6Bit) {
				$row = 0;
				$column = 0;
				$bin_Row = "";
				$bin_Row .= $bin_6Bit[0];
				$bin_Row .= $bin_6Bit[5];
				if($bin_Row == "00") $row = 0;
				if($bin_Row == "01") $row = 1;
				if($bin_Row == "10") $row = 2;
				if($bin_Row == "11") $row = 3;
				$bin = "";
				for($i=1; $i<5; $i++)
					$bin .= $bin_6Bit[$i];
				$column = $this->convert_From_BIN_To_DEC($bin);
				$bin = "";
				$bin_48Bit = "";
				switch($this->S[$k++][$row][$column]){
					case 0:
		                $bin_4Bit = "0000";
		                break;
		            case 1:
		                $bin_4Bit = "0001";
		                break;
		            case 2:
		                $bin_4Bit = "0010";
		                break;
		            case 3:
		                $bin_4Bit = "0011";
		                break;
		            case 4:
		                $bin_4Bit = "0100";
		                break;
		            case 5:
		                $bin_4Bit = "0101";
		                break;
		            case 6:
		                $bin_4Bit = "0110";
		                break;
		            case 7:
		                $bin_4Bit = "0111";
		                break;
		            case 8:
		                $bin_4Bit = "1000";
		                break;
		            case 9:
		                $bin_4Bit = "1001";
		                break;
		            case 10:
		                $bin_4Bit = "1010";
		                break;
		            case 11:
		                $bin_4Bit = "1011";
		                break;
		            case 12:
		                $bin_4Bit = "1100";
		                break;
		            case 13:
		                $bin_4Bit = "1101";
		                break;
		            case 14:
		                $bin_4Bit = "1110";
		                break;
		            case 15:
		                $bin_4Bit = "1111";
		                break;
        		}
    			$bin_32Bit .= $bin_4Bit;
    			$bin_4Bit = "";
				}
				$bin_48Bit = "";
				for($i=0; $i<32; $i++)
					$bin_48Bit[$i] = $bin_32Bit[$this->P[$i]-1];

				return $bin_48Bit;
		}
		
		public function convert_From_BIN_To_DEC($bin){
			$dec = 0;
			$totalLen = strlen($bin);
			for($i=$totalLen-1; $i>=0; $i--){
				$val = ord($bin[$i])-0x30;
				if($val == 0)
					continue;
				$dec += number_format(pow(2, $totalLen-$i-1));
			}
			return $dec;
		}

		public function BlocingPer64Bit($text){
			$binary = $this->makeBinaryArray($text);
			$blocking64Bit = array();
			$A = "";
			$B = "";
			for($i=0; $i<128; $i++){
				if($i<64)
				 $A .= $binary[$i];
				else
				 $B .= $binary[$i];  
			}
			array_push($blocking64Bit, $A);
			array_push($blocking64Bit, $B);
			return $blocking64Bit;
		}

		public function makeBinaryArray($text){
			$binary = "";
			for($i=0; $i<strlen($text); $i++) 
				$binary .= $this->convert_From_HEX_To_BIN($text[$i]);
			return $binary;
		}

		public function convert_From_HEX_To_BIN($hex){
			$value = ord($hex)-0x30;
			if($hex == 'a' || $hex == 'A') $value = 10;
			if($hex == 'b' || $hex == 'B') $value = 11;
			if($hex == 'c' || $hex == 'C') $value = 12;
			if($hex == 'd' || $hex == 'D') $value = 13;
			if($hex == 'e' || $hex == 'E') $value = 14;
			if($hex == 'f' || $hex == 'F') $value = 15;
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
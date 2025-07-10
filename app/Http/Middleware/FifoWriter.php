<?php
namespace App\Http\Middleware;

class FifoWriter{
	function write2fifo($fifo_cmd1,$parameter=""){
		if(!is_file("/var/run/hss.pid")){	//	aaaauthd가 죽은 경우에는 쓸것도, 기다릴것도 없다.
			return true;
		}
		
		$fifo_server = "/var/run/hss_fifo";
		$reply_name = "webfifo_".rand();
		$reply_fifo_path = "/var/cache/httpd/".$reply_name;
		
		if(!empty($parameter)){
			$parameter = "\n" . $parameter;
		}

		$fifo_cmd=$fifo_cmd1.$reply_name.$parameter."\n";
		/* check if fifo is running */
		if(!file_exists($fifo_server) or filetype($fifo_server)!="fifo"){
			return false;
		}
		/* open fifo now */
		$fifo_handle=fopen($fifo_server, "w");
		if(!$fifo_handle){	return false;	}

		/* create fifo for replies */
		@system("mkfifo -m 666 ".$reply_fifo_path);
		/* open before writing fifo command with fear of missing any replies */
		@$fp = fopen($reply_fifo_path, "r+");
		if(!$fp){
			@unlink($reply_fifo_path);
			return false;
		}
		stream_set_blocking($fp, false);

		/* write fifo command */
		if (fwrite($fifo_handle, $fifo_cmd)==-1){
			@unlink($reply_fifo_path);
			@fclose($fifo_handle);
			return false;
		}
		@fclose($fifo_handle);

		/* try to read output now */
		$res = "";

		$streams=[$fp];
		$writeStreams = NULL;
		$except = NULL;
		$timeout=3;
		$numReadyStreams = stream_select($streams, $writeStreams , $except , $timeout);
		if ($numReadyStreams>0) {
			// read out status code in the first line
			$status=fgets($fp, 256);
			if ($this->filterResult($status) == 200) {
				while ($line=fgets($fp,1024)) {
					$res.=$line;
				}
			}
		}
		else {
		}
		@fclose($fp);
		@unlink($reply_fifo_path);
		return $res;
	}
	
	//reply fifo에서 얻어낸 상태값을 파라메터로 받아서 수값부분만 되돌린다.
	private function filterResult($status){
		$status = preg_replace("/[a-zA-Z ]/","",$status);
		return $status;
	}

}

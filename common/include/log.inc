<?php

class logManager {

	function logManager(){
		date_default_timezone_set("PRC");
	}
	
	function httpLog( $Response ){
			$txt = "../../log/http.log";
			$addLogStr = "\r\n" . date('Y-m-d H:i:s'). " " 
						.$_SERVER['PHP_SELF'] ." " 
						.$_SERVER["REMOTE_ADDR"] ." "
						.serialize($_POST) ." "
						.$Response 
						. "\r\n";
			$fp = fopen($txt,"a+");
			fwrite($fp,$addLogStr);
			fclose($fp);
	}
	
	function sqlLog( $sqlStr ){
		$txt = "../../log/mysql.log";
		$addLogStr = date('Y-m-d H:i:s'). " " .  $_SERVER['PHP_SELF'] ." " . $sqlStr . "\r\n";
		$fp = fopen($txt,"a+");
		fwrite($fp,$addLogStr);
		fclose($fp);
	}
}



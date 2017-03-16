<?php
/*
@名称：错误类
@功能：设置和显示程序中产生的错误信息
@作者：李建军
@开发时间：2008-4-2
*/
class Error {
	var $err_no		=0;			//出错代码
	var $error_info		='empty';			//出错信息，一般从来自系统的返回的错误。
	var $error_msg		='empty';			//出错提示，用户自定义的错误信息。
	var $error_file		='empty';			//出错文件，发生错误的文件。
	var $error_class	='empty';			//出错类
	var $error_sql		='empty';				//出错SQL

	function setErrorNo($p_error_no){
		$this->err_no=$p_error_no;
		return true;
	}

	function getErrorNo(){
		return $this->err_no;
	}

	function setErrorInfo($p_error_info){
		$this->error_info=$p_error_info;
		return true;
	}

	function getErrorInfo(){
		return $this->error_info;
	}

	function setErrorMsg($p_error_msg){
		$this->error_msg=$p_error_msg;
		return true;
	}

	function getErrorMsg(){
		return $this->error_msg;
	}

	function setErrorFile($p_error_file){
		$this->error_file=$p_error_file;
		return true;
	}

	function getErrorFile(){
		return $this->error_file;
	}

	function setErrorClass($p_error_class){
		$this->error_class=$p_error_class;
		return true;
	}

	function getErrorClass(){
		return $this->error_class;
	}

	function setErrorSql($p_error_sql){
		$this->error_sql=$p_error_sql;
		return true;
	}

	function getErrorSql(){
		return $this->error_sql;
	}


	/*
	@名称：显示出数据库操作时的出错信息
	@功能：显示出数据库操作时的出错信息，并且可以控制是否显示出错的SQL信息
	*/	
	function showErrors($show_sql_flag=false) {
		
		$full_file_path	= getenv("SCRIPT_NAME");//获得当前运行的脚本文件的全路径
		$tmp_array		= split("/",$full_file_path);
		$error_file		="";

		if(count($tmp_array) >1)
			$error_file = $tmp_array[(count($tmp_array)-1)];
		
		$path = P_HOMEPAGE_URL;
		
		echo 'errorfile: '.$this->getErrorFile().'<br>';
		echo 'errorclass: '.$this->getErrorClass().'<br>';
		echo 'errorMsg: '.$this->getErrorMsg().'<br>';
		echo 'errorInfo: '.$this->getErrorInfo().'<br>';
	}
}

?>
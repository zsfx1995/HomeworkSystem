<?php
/*
@���ƣ�������
@���ܣ����ú���ʾ�����в����Ĵ�����Ϣ
@���ߣ����
@����ʱ�䣺2008-4-2
*/
class Error {
	var $err_no		=0;			//��������
	var $error_info		='empty';			//������Ϣ��һ�������ϵͳ�ķ��صĴ���
	var $error_msg		='empty';			//������ʾ���û��Զ���Ĵ�����Ϣ��
	var $error_file		='empty';			//�����ļ�������������ļ���
	var $error_class	='empty';			//������
	var $error_sql		='empty';				//����SQL

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
	@���ƣ���ʾ�����ݿ����ʱ�ĳ�����Ϣ
	@���ܣ���ʾ�����ݿ����ʱ�ĳ�����Ϣ�����ҿ��Կ����Ƿ���ʾ������SQL��Ϣ
	*/	
	function showErrors($show_sql_flag=false) {
		
		$full_file_path	= getenv("SCRIPT_NAME");//��õ�ǰ���еĽű��ļ���ȫ·��
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
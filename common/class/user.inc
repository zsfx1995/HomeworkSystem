<?php
	/***********************************************************************
	 * Module:  php.inc
	 * Author:  李建军
	 *Date   :2008-4-3
	 * Purpose:表操作(增,修,删,改,查)
	 ***********************************************************************/

	class user extends BaseTable{
	     /*
	@名称：建构函数
	@功能：构建对象，同时设定具体的数据库表的名称
	*/ 
  function user(){
		$this->BaseTable();
		$this->setTableName('t_userinfo');		
	}  
	
      /*增加数据*/
	function  addRecorded(){
 	   if($this->addRecord()){			
			 return true;
		 		}
		 	else{			
				return false;
					}
	   }
	  /*更新数据*/    
	 function  updateRecorded() {
			if($this->updateRecord()){
				return true;}
			else{
				return false;}
	   }
	   /*删除数据*/  	 
	  function  deleteRecorded() {
		if($this->deleteRecord())
			return true;
		else
			return false;
	   }

	   
	  /*根据UID进行查询*/
	 function  s_Search($Uid="") {
		
		$Str='';
		if(strlen($Uid)>0){			
			$Str.=" AND Uid='$Uid'";			
		}
		
		$strOrderby=" order by Uid desc";

		$strSQL="SELECT * FROM t_userinfo  Where 1 ".$Str.$strOrderby;
		$tmp_result=$this->openQuery($strSQL) ;
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Search t_userinfo Error!','user.inc','user',$strSQL);
		}
		return $tmp_result;
   }  
   
   /*身份验证查询*/
   function  searchuser($type,$login_name,$login_pwd){	
		if( $type == 1 ){
			$strSQL="SELECT * FROM t_userinfo where 1=1 and mail ='$login_name'&&password='$login_pwd'";
		}else{
			$strSQL="SELECT * FROM t_userinfo where 1=1 and phoneNum ='$login_name'&&password='$login_pwd'";
		}
		
		$tmp_result=$this->openQuery($strSQL) ;
		
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Searche t_userinfo Error!','user.inc','user',$strSQL);
		    return false;
		}	
	
		return $tmp_result;	
	}
   
   
	    /*核对用户名是否使用*/
	function  CheckNewUserID($type , $mail , $phone ){		
		if( $type == 1 )
			$strSQL="SELECT * FROM t_userinfo where 1=1 and mail ='$mail'";
		else
			$strSQL="SELECT * FROM t_userinfo where 1=1 and phoneNum ='$phone'";
		//echo $strSQL;
		
		$tmp_result=$this->openQuery($strSQL) ;
		
		if(!$tmp_result){
			$this->setError(@mysql_error($this->db_connection),'Searche t_user_info Error!','user.inc','user',$strSQL);
		    return false;
		}	
		return $tmp_result;	
	   }
	   
	   	  
  /*数据传递*/ 
		function getUid(){
			return $this-> getAttriValue('Uid');
		}
		function getUserName(){
			return $this-> getAttriValue('userName');
		}
		function getPassword(){
		
			return $this-> getAttriValue('password');
		}
		function getMail(){
			return $this-> getAttriValue('mail');
		}
		function getPhone(){
			return $this-> getAttriValue('phoneNum');
		}
		function getAcitivityList(){
			return $this-> getAttriValue('acitivityList');
		}
		function getSubList(){
			return $this-> getAttriValue('subList');
		}
		function getScore(){
			return $this-> getAttriValue('score');
		}
		
		function getPicUrl(){
			return $this-> getAttriValue('PicUrl');
		}
		
		 function setUserName($a){
			$this->setAttriValue('UserName',$a) ;
		}
		function setPassword($a){
			$this->setAttriValue('Password',$a) ;
		}
		function setMail($a){
			$this->setAttriValue('Mail',$a) ;
		}
		function setPhone($a){
			$this->setAttriValue('PhoneNum',$a) ;
		}
		function setAcitivityList($a){
			$this->setAttriValue('AcitivityList',$a) ;
		}
		function setSubList($a){
			$this->setAttriValue('Sublist',$a) ;
		}
		function setScore($a){
			$this->setAttriValue('Score',$a) ;
		}
		function setPicUrl($a){
			$this->setAttriValue('PicUrl',$a) ;
		}
		
		}